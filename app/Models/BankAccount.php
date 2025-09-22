<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'account_number';
    }

    public function credits()
    {
        return $this->hasMany(BankDeposit::class, 'bank_account_id', 'account_number');
    }

    public function debits()
    {
        return $this->hasMany(BankWithdrawal::class, 'bank_account_id', 'account_number');
    }

    public function trailBalance()
    {
        return $this->hasMany(TrailBalance::class, 'account_number', 'account_number')->orderBy('id', 'desc');
    }

    public function getTotalDepositsAttribute()
    {
        return number_format($this->credits()->sum('amount'), 2);
    }

    public function getTotalDebitsAttribute()
    {
        return number_format($this->debits()->sum('amount'), 2);
    }

    public function getBalanceAttribute()
    {
        return number_format($this->credits()->sum('amount') - $this->debits()->sum('amount'), 2);
    }
}
