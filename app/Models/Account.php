<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    // Types of accounts
    public const SAVINGS = 'savings';
    public const SUSU = 'susu';

    public function getFullNameAttribute()
    {
        return ucwords($this->first_name . " " . $this->other_names . " " . $this->last_name);
    }

    public function getAmountAttribute()
    {
        return moneyFormat($this->payment_amount);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'account_number', 'account_number')
            ->orderBy('date_of_deposit', 'desc')
            ->where('approval_status', 1);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'account_number', 'account_number')
            ->orderBy('date_of_withdrawal', 'desc')
            ->where('approval_status', 1);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'account_number', 'account_number')->latest();
    }

    public function summary()
    {
        return $this->hasMany(AccountTrialBalance::class, 'account_number', 'account_number')->latest('updated_at');
    }

    // deposits
    public function getTotalDepositsAttribute()
    {
        return $this->deposits()->sum('amount');
    }

    // withdrawals
    public function getTotalWithdrawalsAttribute()
    {
        return $this->withdrawals()->sum('amount');
    }

    // commissions
    public function getCommissionsPaidAttribute()
    {
        return $this->commissions()->where('source', '!=', Commission::PASS_BOOK)->sum('amount');
    }

    public function getCommissionsCreditedAttribute()
    {
        return $this->commissions()->where('source', '!=', Commission::PASS_BOOK)->where('source', '!=', Commission::MONTHLY_SMS_FEE)->sum('amount');
    }

    // total balances
    public function getBalanceAttribute()
    {
        return moneyFormat($this->actual_balance);
    }

    public function getActualBalanceAttribute()
    {
        return $this->total_deposits - $this->total_withdrawals - $this->commissions_credited;
    }

    public function getProfilePhotoAttribute()
    {
        if (!empty($this->photo)) {
            return asset('dougystar/public/' . $this->photo);
        }
        return "https://ui-avatars.com/api/?name=" . urlencode($this->full_name) . "&background=507b8c&Color=ffffff";
    }

    public function getNumberOfTransactionsAttribute()
    {
        return $this->deposits()->where('account_type', $this->account_type)->count();
    }

    public function getBaseAmountAttribute()
    {
        return $this->payment_amount;
    }

    public function getCommissionForDepositAttribute()
    {
        return $this->number_of_transactions % 31;
    }

    public function getCommissionWithdrawalAttribute()
    {
        if ($this->commission_for_deposit != 0 && $this->number_of_transactions) {
            return $this->base_amount;
        }

        return 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'registered_by')->withTrashed();
    }

    public function getAccountTypeAttribute()
    {
        return ($this->susu_account) ? self::SUSU : self::SAVINGS;
    }

    public function getPassbookBalanceAttribute()
    {
        return Commission::PASS_BOOK_FEE - $this->passbook_amount_paid;
    }

    public function getPassbookAmountPaidAttribute()
    {
        return $this->commissions->where('source', Commission::PASS_BOOK)->sum('amount');
    }

    public function getPassbookStatusAttribute()
    {
        return $this->passbook_amount_paid >= Commission::PASS_BOOK_FEE ? true : false;
    }
}
