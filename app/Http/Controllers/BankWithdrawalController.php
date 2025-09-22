<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\TrailBalance;
use Illuminate\Http\Request;
use App\Models\BankWithdrawal;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\BankWithdrawalRequest;

class BankWithdrawalController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $accounts = BankAccount::get();
        return view('bank-withdrawals.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankWithdrawalRequest $request)
    {
        $bankWithdrawal =  new BankWithdrawal();
        $bankWithdrawal->bank_account_id = $request->account_number;
        $bankWithdrawal->date_of_withdrawal = $request->date_of_withdrawal;
        $bankWithdrawal->cheque_number = $request->cheque_number;
        $bankWithdrawal->amount = $request->amount;
        $bankWithdrawal->user_id = auth()->id();
        $bankWithdrawal->saveOrFail();

        $this->logTrailBalance($bankWithdrawal);

        Alert::success('Success', 'Withdrawal recorded successfully');
        return redirect()->route('bank-accounts.show', $request->account_number);
    }

    public function logTrailBalance($account)
    {
        $trailBalance = new TrailBalance();
        $trailBalance->transaction_date = $account->date_of_withdrawal;
        $trailBalance->transaction_id = $account->id;
        $trailBalance->amount = $account->amount;
        $trailBalance->account_number = $account->bank_account_id;
        $trailBalance->balance = floatval(preg_replace('/[^\d.]/', '', $account->bankAccount->balance));
        $trailBalance->description = 'debit';
        $trailBalance->saveOrFail();
    }
}
