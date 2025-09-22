<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Traits\SmsTrait;
use App\Models\Commission;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Traits\LogCommission;
use App\Models\AccountTrialBalance;
use App\Repositories\AccountRpository;
use App\Http\Requests\WithdrawalRequest;
use RealRashid\SweetAlert\Facades\Alert;

class WithdrawalController extends Controller
{
    use SmsTrait, LogCommission;

    public function index(Request $request, AccountRpository $accountRpository)
    {
        if ($request->get('date')) {
            $withdrawals = Withdrawal::where('date_of_withdrawal', $request->date)->latest()->get();
            return view('withdrawals.details', compact('withdrawals'));
        }

        $withdrawals = $accountRpository->withdrawals();
        return view('withdrawals.index', compact('withdrawals'));
    }

    public function create()
    {
        $accounts = Account::get();
        return view('withdrawals.create', compact('accounts'));
    }

    public function store(WithdrawalRequest $request)
    {
        $withdrawal = new Withdrawal;
        $withdrawal->account_number = $request->account_number;
        $withdrawal->date_of_withdrawal = $request->date_of_withdrawal;
        $withdrawal->amount = $request->amount;
        $withdrawal->account_type = $request->account_type;
        $withdrawal->entered_by = auth()->id();
        $withdrawal->saveOrFail();

        Alert::success('Success', 'Withdrawal recorded successfully and pending approval');
        return redirect()->route('withdrawals.index');
    }

    public function sendSmsNotification($withdrawal, $charge)
    {
        $account = $withdrawal->account;
        $number = $account->phone_number_one;
        if ($account->sms_option) {
            $message =  moneyFormat($withdrawal->amount) . ' has been withdrawn from your ' . $account->account_type . '  a/c ******' . substr($account->account_number, 4) . ' on ' . $withdrawal->date_of_withdrawal . '. Charge ' . moneyFormat($charge) . '  A/C Bal: ' . $account->balance . '. Helpline:+233 24 444 8865';
            return $this->collector($message, $number);
        }
    }

    public function logTrailBalance($account)
    {
        $trailBalance = new AccountTrialBalance();
        $trailBalance->transaction_date = $account->date_of_withdrawal;
        $trailBalance->transaction_id = $account->id;
        $trailBalance->amount = $account->amount;
        $trailBalance->account_type = $account->account_type;
        $trailBalance->account_number = $account->account_number;
        $trailBalance->balance = floatval(preg_replace('/[^\d.]/', '', $account->account->actual_balance));
        $trailBalance->transaction_by = $account->entered_by;
        $trailBalance->description = 'debit';
        return $trailBalance->saveOrFail();
    }

    public function commissions($account)
    {
        if (
            $account->commission_for_deposit != 0
            && $account->deposits->count() > 0
            && $account->account_type == Account::SUSU
        ) {
            $amount = $account->account->base_amount;
            return $this->logCommission($account, $amount, Commission::WITHDRAWAL);
        }

        if ($account->account_type == Account::SAVINGS) {
            $amount = ceil($account->amount * 0.01);
            return $this->logCommission($account, $amount, Commission::WITHDRAWAL);
        }
    }

    public function approve(Withdrawal $withdrawal)
    {
        $this->approveTemplate($withdrawal);

        Alert::success('Success', 'Withdrawal approved successfully');
        return redirect()->back();
    }

    public function approveTemplate($withdrawal)
    {
        $withdrawal->approval_status = 1;
        $withdrawal->save();

        $this->logTrailBalance($withdrawal);
        $charge = $this->commissions($withdrawal);
        $this->sendSmsNotification($withdrawal, $charge);
    }

    public function remove(Withdrawal $withdrawal)
    {
        $withdrawal->delete();

        Alert::success('Success', 'Withdrawal removed successfully');
        return redirect()->back();
    }

    public function approveSelected(Request $request)
    {
        $withdrawals = $request->withdrawals;
        if (isset($request['withdrawals'])) {
            foreach ($withdrawals as $id) {
                $withdrawal = Withdrawal::find($id);
                if (isset($_POST['approve_selected'])) {
                    $this->approveTemplate($withdrawal);
                }

                if (isset($_POST['remove'])) {
                    $withdrawal->delete();
                }
            }

            if (isset($_POST['remove'])) {
                Alert::success('Success', 'Selected withdrawals removed successfully');
            } else {
                Alert::success('Success', 'Selected withdrawals approved successfully');
            }
            return redirect()->back();
        }

        Alert::error('Warning', 'Nothing was selected');
        return redirect()->back();
    }

    public function approvals()
    {
        $users = User::withTrashed()->get();
        return view('withdrawals.approvals', compact('users'));
    }

    public function approveAll(Request $request)
    {
        if ($request->query('agent')) {
            $withdrawals = Withdrawal::where('approval_status', 0)->where('entered_by', $request->agent)->get();
        } else {
            $withdrawals = Withdrawal::where('approval_status', 0)->get();
        }
        foreach ($withdrawals as $withdrawal) {
            $this->approveTemplate($withdrawal);
        }

        Alert::success('Success', 'All withdrawals approved successfully');
        return redirect()->back();
    }
}
