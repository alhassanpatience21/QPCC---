<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public function agentAssigned()
    {
        return $this->belongsTo(User::class, 'agent')->withTrashed();
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }
    public function getDateAttribute()
    {
        return date('l F d, Y', strtotime($this->start_date));
    }

    public function getLoanAmountAttribute()
    {
        return $this->principal_amount + $this->interest;
    }

    public function getDaysLeftAttribute()
    {
        $today = Carbon::today();
        $endDate = Carbon::parse($this->end_date);

        return $today->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, $endDate);
    }

    public function loanRepayments()
    {
        return $this->hasMany(LoanRepayment::class, 'loan_id')->orderBy('repayment_date');
    }

    public function getWeeklyBalanceAttribute()
    {
        $loanRepayments = $this->loanRepayments;

        if ($loanRepayments->count()) {
            if (date('w') == date('w', strtotime($loanRepayments->last()->repayment_date))) {
                return $loanRepayments->last()->week_ending_balance;
            }

            if (date('w') != date('w', strtotime($loanRepayments->last()->repayment_date))) {
                return $loanRepayments->last()->week_ending_balance + $this->weekly_repayment_amount;
            }
        }

        return $this->daily_repayment_amount * 5;
    }

    public function getOutstandingBalanceAttribute()
    {
        return $this->loan_amount - $this->loanRepayments->where('approval_status', 1)->sum('amount');
    }
}
