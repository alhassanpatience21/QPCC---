<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankDepositRequest;
use App\Models\BankAccount;
use App\Models\BankDeposit;
use App\Models\TrailBalance;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BankDepositController extends Controller
{
    public function create()
    {
        $accounts = BankAccount::get();
        return view('bank-deposits.create', compact('accounts'));
    }

    public function store(BankDepositRequest $request)
    {
        $bankDeposit =  new BankDeposit();
        $bankDeposit->bank_account_id = $request->account_number;
        $bankDeposit->date_of_deposit = $request->date_of_deposit;
        $bankDeposit->mode_of_deposit = $request->mode_of_deposit;
        $bankDeposit->deposited_by = $request->deposited_by;
        $bankDeposit->deposit_slip_number = $request->slip_number;
        $bankDeposit->amount = $request->amount;
        $bankDeposit->user_id = auth()->id();
        $bankDeposit->saveOrFail();

        $this->logTrailBalance($bankDeposit);

        Alert::success('Success', 'Deposit made successfully');
        return redirect()->route('bank-accounts.show', $request->account_number);
    }

    public function logTrailBalance($account)
    {
        $trailBalance = new TrailBalance();
        $trailBalance->transaction_date = $account->date_of_deposit;
        $trailBalance->transaction_id = $account->id;
        $trailBalance->amount = $account->amount;
        $trailBalance->account_number = $account->bank_account_id;
        $trailBalance->balance = floatval(preg_replace('/[^\d.]/', '', $account->bankAccount->balance));
        $trailBalance->description = 'credit';
        $trailBalance->saveOrFail();
    }
}
