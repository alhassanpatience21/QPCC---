<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Models\User;
use App\Models\Account;
use App\Models\LoanRepayment;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoanController extends Controller
{
    use SmsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = ($request->type != 'completed') ? 0 : 1;
        $loans = Loan::where('approval_status', 1)->where('status', $status)->get();
        return view('loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::get();
        $agents = User::where('email', '!=', 'admin@sageitservices.com')->get();
        return view('loans.create', compact('accounts', 'agents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanRequest $request)
    {
        $loan = new Loan();
        $loan->account_number = $request->account_number;
        $loan->principal_amount = $request->principal;
        $loan->interest = $request->interest;
        $loan->daily_repayment_amount = $request->daily_repayment_amount;
        $loan->weekly_repayment_amount = $request->weekly_repayment_amount;
        $loan->duration = $request->duration;
        $loan->start_date = $request->start_date;
        $loan->end_date = $request->end_date;
        $loan->agent = $request->agent;
        $loan->processing_fee = $request->processing_fee;
        $loan->first_guarantor_Fname = $request->first_guarantor_Fname;
        $loan->first_guarantor_gender = $request->first_guarantor_gender;
        $loan->first_guarantor_phone_number = $request->first_guarantor_phone_number;
        $loan->first_guarantor_address = $request->first_guarantor_address;
        $loan->first_guarantor_landmark = $request->first_guarantor_landmark;
        $loan->first_guarantor_occupation = $request->first_guarantor_occupation;
        $loan->first_guarantor_id_type = $request->first_guarantor_id_type;
        $loan->first_guarantor_id_number = $request->first_guarantor_id_number;
        $loan->save();

        Alert::success('Successful', 'Loan disbursed successfully');


        return redirect()->route('loans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        Alert::success('Success', 'Loan removed successfully for ' . $loan->account->account_name);
        return redirect()->back();
    }

    public function approvals()
    {
        $users = User::get();
        return view('loans.approvals', compact('users'));
    }

    public function approve(Loan $loan)
    {
        $loan->approval_status = 1;
        $loan->saveOrFail();

        $account = $loan->account;

        if ($account->sms_option && $account->phone_number_one != '') {
            $number = array($account->phone_number_one);
            $message = 'Hello  ' . $account->account_name . ' (' . $account->account_number . '),  a loan of ' . moneyFormat($loan->loan_amount) . ' has been credited to you. Helpline:+233 57 790 5906';
            return $this->collector($message, $number);
        }

        Alert::success('Success', 'Loan approved successfully for ' . $account->account_name);
        return redirect()->back();
    }

    public function allRepayments()
    {
        if (request()->get('date')) {
            $loanRepayments = LoanRepayment::where('repayment_date', request()->date)->latest()->get();
            return view('loans.repayment-details', compact('loanRepayments'));
        }

        $loanRepayments =  LoanRepayment::get();
        return view('loans.repayments', compact('loanRepayments'));
    }
}
