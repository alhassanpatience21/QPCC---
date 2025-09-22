<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BankDeposit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BankAccountController extends Controller
{
    public function index()
    {
        $banks = BankAccount::get();
        return view('bank-accounts.index', compact('banks'));
    }

    public function create()
    {
        return view('bank-accounts.create');
    }

    public function store(Request $request)
    {
        $bankAccount = new BankAccount;
        $bankAccount->account_name = $request->account_name;
        $bankAccount->account_description = $request->account_description;
        $bankAccount->account_number = $request->account_number;
        $bankAccount->account_branch = $request->account_branch;
        $bankAccount->saveOrFail();

        Alert::success('Success', 'Bank Account created successfully');
        return redirect()->route('bank-accounts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        return view('bank-accounts.show', compact('bankAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        //
    }
}
