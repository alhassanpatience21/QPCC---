<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountTrialBalance;
use App\Models\Commission;
use App\Models\Deposit;
use App\Models\SmsSetting;
use App\Models\Withdrawal;
use App\Repositories\AccountRpository;

class HomeController extends Controller
{
    public $account;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AccountRpository $accountRpository)
    {
        $this->account = $accountRpository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $deposits = $this->account->deposits();
        $withdrawals = $this->account->withdrawals();
        $accounts =  $this->account->accounts();
        $commissions = $this->account->commissions();
        $accountTrailBalance = AccountTrialBalance::orderBy('updated_at', 'desc')->get()->take(15);
        $smsSettings = SmsSetting::first();
        return view('home', compact('accounts', 'accountTrailBalance', 'deposits', 'withdrawals', 'commissions', 'smsSettings'));
    }
}
