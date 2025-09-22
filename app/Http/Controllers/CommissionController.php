<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Commission;
use App\Traits\LogCommission;
use Illuminate\Http\Request;
use App\Repositories\AccountRpository;
use RealRashid\SweetAlert\Facades\Alert;

class CommissionController extends Controller
{
    use LogCommission;

    public function index()
    {
        $this->authorize('view-any', User::class);

        $commissions = Commission::latest()->where('source', '!=', Commission::PASS_BOOK)->get();
        return view('commissions.index', compact('commissions'));
    }

    public function monthlySmsCharge()
    {
        $accounts = Account::get();
        foreach ($accounts as $account) {
            $this->logCommission($account, Commission::MONTHLY_SMS_FEE, Commission::MONTHLY_SMS);
        }
    }
    public function passbookFees(AccountRpository $accountRpository)
    {
        $accounts = $accountRpository->accounts();
        return view('commissions.passbook', compact('accounts'));
    }

    public function passbookFeesSummary(AccountRpository $accountRpository)
    {
        $fees = $accountRpository->passbookFees();
        return view('commissions.passbook-summary', compact('fees'));
    }

    public function passbookFeesStore(Request $request)
    {
        if ($request->amount != 0) {
            $account = Account::where('account_number', $request->account)->first();
            $this->logCommission($account, $request->amount, Commission::PASS_BOOK);
        }

        Alert::success('Success', 'Passbook fee saved successfully');
        return redirect()->back();
    }
}
