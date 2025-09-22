<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Account;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use App\Models\LoanRepayment;
use App\Traits\LogCommission;
use App\Models\AccountTrialBalance;
use RealRashid\SweetAlert\Facades\Alert;

class LoanRepaymentController extends Controller
{
    use SmsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::where('status', 0)->get();
        return view('loan-repayments.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $outstandingLoans = Loan::where('status', 0)->get();
        return view('loan-repayments.create', compact('outstandingLoans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loanRepayment = new LoanRepayment();
        $loanRepayment->loan_id = $request->account_number;
        $loanRepayment->entered_by = auth()->id();
        $loanRepayment->amount = $request->repayment_amount;
        $loanRepayment->repayment_date = $request->repayment_date;
        $loanRepayment->week_ending_balance = $request->weekly_repayment_amount;
        $loanRepayment->ending_balance = $request->outstanding_balance;
        $loanRepayment->balance = $request->outstanding_balance;
        $loanRepayment->saveOrFail();

        Alert::success('Successful', 'Loan repayment recorded successfully. Awaiting approval');
        return redirect()->route('loans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoanRepayment  $loanRepayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoanRepayment $loanRepayment)
    {
        $loanRepayment->delete();

        Alert::success('Success', 'Loan Repayment removed successfully');
        return redirect()->back();
    }

    public function approve(LoanRepayment $loanRepayment)
    {
        $loanRepayment->approval_status = 1;
        $loanRepayment->save();

        $this->logTrailBalance($loanRepayment);

        if ($loanRepayment->loan->loanRepayments->sum('amount') >= $loanRepayment->loan->loan_amount) {
            $loan = $loanRepayment->loan();
            $loan->status = 1;
            $loan->save();
        }

        if ($loanRepayment->loan->account->sms_option) {
            $number = $loanRepayment->loan->account->phone_number_one;
            $message = moneyFormat($loanRepayment->amount) . " has been received as part payment of your loan amount on " . $loanRepayment->repayment_date . ". LOAN OUTSTANDING BAL: " . moneyFormat($loanRepayment->loan->outstanding_balance);
            $this->collector($message, $number);
        }

        Alert::success('Success', 'Loan repayment approved successfully');
        return redirect()->back();
    }

    public function logTrailBalance($loanRepayment)
    {
        $trailBalance = new AccountTrialBalance();
        $trailBalance->transaction_date = $loanRepayment->repayment_date;
        $trailBalance->transaction_id = $loanRepayment->id;
        $trailBalance->amount = $loanRepayment->amount;
        $trailBalance->account_type = $loanRepayment->loan->account->account_type;
        $trailBalance->account_number = $loanRepayment->loan->account_number;
        $trailBalance->balance = floatval(preg_replace('/[^\d.]/', '', $loanRepayment->loan->outstanding_balance));
        $trailBalance->description = 'loan_repayment';
        $trailBalance->transaction_by = $loanRepayment->entered_by;
        $trailBalance->approval_status = 1;
        $trailBalance->saveOrFail();
    }
}
