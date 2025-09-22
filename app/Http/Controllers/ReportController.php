<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\Commission;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\AccountTrialBalance;
use App\Http\Requests\ReportRequest;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::get();
        $agents = User::notAdmin()->get();
        return view('reports.index', compact('accounts', 'agents'));
    }

    public function filter(ReportRequest $request)
    {
        // dd($request->all());
        $from = $request->from;
        $to = $request->to;
        $options = $request->options;
        $account_number = $request->account_number;
        $agent = $request->agent;

        switch ($request->type) {
            case 'Deposits':
                $deposits = Deposit::approved()->whereBetween('date_of_deposit', [$from, $to])->get();
                if (!empty($agent)) {
                    $deposits = $deposits->where('entered_by', $agent);
                }
                if (!empty($account_number)) {
                    $deposits = $deposits->where('account_number', $account_number);
                }
                return view('reports.deposits', compact('deposits'));
                break;
            case 'Withdrwals':
                $withdrawals = Withdrawal::approved()->whereBetween('date_of_withdrawal', [$from, $to])->get();
                if (!empty($agent)) {
                    $withdrawals = $withdrawals->where('entered_by', $agent);
                }
                if (!empty($account_number)) {
                    $withdrawals = $withdrawals->where('account_number', $account_number);
                }
                return view('reports.withdrawals', compact('withdrawals'));
                break;
            case 'Commissions':
                $commissions = Commission::whereBetween('created_at', [$from, $to])->get();
                if (!empty($agent)) {
                    $commissions = $commissions->where('entered_by', $agent);
                }
                if ($options != 'All') {
                    $commissions = $commissions->where('source', $options);
                }
                if (!empty($account_number)) {
                    $commissions = $commissions->where('account_number', $account_number);
                }
                return view('reports.commissions', compact('commissions'));
                break;
            case 'Account Opening':
                $accounts = Account::whereBetween('created_at', [$from, $to])->get();
                if (!empty($agent)) {
                    $accounts = $accounts->where('registered_by', $agent);
                }
                return view('reports.accounts', compact('accounts'));
                break;
            case 'sms':
                $accounts = Account::get();
                if ($options != 'All') {
                    $accounts = $accounts->where('sms_option', $options);
                }
                return view('reports.sms', compact('accounts'));
                break;
            case 'Loan':
                if ($options != 'Repayment') {
                    $loans = Loan::whereBetween('created_at', [$from, $to])->get();
                    if ($options != 'Disbursement') {
                        $loans = $loans->where('status', $options);
                        # code...
                    }
                    return view('reports.loans', compact('loans'));
                }
                break;
            case 'Statement':
                $accounts = AccountTrialBalance::whereBetween('transaction_date', [$from, $to])->get();
                if (!empty($account_number)) {
                    $accounts = $accounts->where('account_number', $account_number);
                    return view('reports.trial-balance', compact('accounts'));
                }
                if ($options == 'all_accounts') {
                    $accounts = Account::get();
                    return view('reports.all-accounts', compact('accounts', 'from', 'to'));
                }
                break;
            default:
                return redirect()->route('reports');
                break;
        }
    }
}
