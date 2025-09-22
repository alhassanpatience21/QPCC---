<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\AccountTrialBalance;
use App\Models\Commission;
use App\Models\Deposit;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\DB;

class AccountRpository
{
    public function accounts()
    {
        if (auth()->user()->role == 'Agent') {
            return Account::latest()
                ->where('registered_by', auth()->id())
                ->get();
        } else {
            return Account::latest()->get();
        }
    }

    public function deposits()
    {
        if (auth()->user()->role == 'Agent') {
            return Deposit::with('agent', 'account', 'user')->latest()
                ->where('entered_by', auth()->id())
                ->where('date_of_deposit', Carbon::today())
                ->get();
        } else {
            return Deposit::with('agent', 'account', 'user')->latest()->get();
        }
    }
    
   public function depositAll()
    {
        if (auth()->user()->role == 'Agent') {
            return Deposit::with(['agent:id,name', 'account'])
                ->select('id', 'account_number', 'date_of_deposit', 'amount', 'account_type', 'approval_status', 'entered_by')
                ->where('entered_by', auth()->id())
                ->where('date_of_deposit', Carbon::today())
                ->latest()
                ->get();
        } else {
            return Deposit::with(['agent:id,name', 'account'])
                ->select('id', 'account_number', 'date_of_deposit', 'amount', 'account_type', 'approval_status', 'entered_by')
                ->latest()
                ->get();
        }
    }
    
    /**
     * Get summary totals for deposits
     * 
     * @return array
     */
    public function depositSummary()
    {
        if (auth()->user()->role == 'Agent') {
            $result = Deposit::where('entered_by', auth()->id())
                ->where('date_of_deposit', Carbon::today())
                ->select(
                    DB::raw('SUM(CASE WHEN approval_status = 1 THEN amount ELSE 0 END) as approved_total'),
                    DB::raw('SUM(CASE WHEN approval_status = 0 THEN amount ELSE 0 END) as pending_total'),
                    DB::raw('SUM(amount) as grand_total')
                )
                ->first();
        } else {
            $result = Deposit::select(
                DB::raw('SUM(CASE WHEN approval_status = 1 THEN amount ELSE 0 END) as approved_total'),
                DB::raw('SUM(CASE WHEN approval_status = 0 THEN amount ELSE 0 END) as pending_total'),
                DB::raw('SUM(amount) as grand_total')
            )
            ->first();
        }
        
        return [
            'approved' => $result->approved_total ?? 0,
            'pending' => $result->pending_total ?? 0,
            'total' => $result->grand_total ?? 0
        ];
    }
    
    /**
     * Get date summary for admin dashboard
     * 
     * @return \Illuminate\Support\Collection
     */
    public function depositDateSummary()
    {
        return DB::table('deposits')
            ->select(
                'date_of_deposit', 
                DB::raw('SUM(CASE WHEN approval_status = 1 THEN amount ELSE 0 END) as approved_total'),
                DB::raw('SUM(CASE WHEN approval_status = 0 THEN amount ELSE 0 END) as pending_total'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('date_of_deposit')
            ->orderBy('date_of_deposit', 'desc')
            ->take(50)
            ->get();
    }
    
    /**
     * Get only the most recent deposits (limited records)
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function recentDeposits()
    {
        if (auth()->user()->role == 'Agent') {
            return Deposit::with(['agent:id,name', 'account'])
                ->select('id', 'account_number', 'date_of_deposit', 'amount', 'account_type', 'approval_status', 'entered_by')
                ->where('entered_by', auth()->id())
                ->where('date_of_deposit', Carbon::today())
                ->latest()
                ->take(10)
                ->get();
        } else {
            // For admin, instead of loading all deposits and filtering unique dates,
            // directly get the unique dates with their summaries
            return $this->depositDateSummary();
        }
    }
    
    public function withdrawals()
    {
        if (auth()->user()->role == 'Agent') {
            return Withdrawal::latest()
                ->where('entered_by', auth()->id())
                ->where('date_of_withdrawal', Carbon::today())
                ->get();
        } else {
            return Withdrawal::latest()->get();
        }
    }
    
    public function commissions()
    {
        if (auth()->user()->role == 'Agent') {
            return Commission::latest()
                ->where('entered_by', auth()->id())
                ->where('created_at', Carbon::today())
                ->where('source', '!=', Commission::PASS_BOOK)
                ->get();
        } else {
            return Commission::latest()
                ->where('source', '!=', Commission::PASS_BOOK)
                ->get();
        }
    }
    
    public function passbookFees()
    {
        if (auth()->user()->role == 'Agent') {
            return Commission::latest()
                ->where('entered_by', auth()->id())
                ->where('created_at', Carbon::today())
                ->where('source', '=', Commission::PASS_BOOK)
                ->get();
        } else {
            return Commission::latest()
                ->where('source', '=', Commission::PASS_BOOK)
                ->get();
        }
    }
    
    public function trialBalance()
    {
        if (auth()->user()->role == 'Agent') {
            return AccountTrialBalance::latest()
                ->where('entered_by', auth()->id())
                ->where('transaction_date', Carbon::today())
                ->get();
        } else {
            return AccountTrialBalance::latest()->get();
        }
    }
}