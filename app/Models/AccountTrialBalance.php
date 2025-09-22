<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTrialBalance extends Model
{
    use HasFactory;

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function transactionSource()
    {
        switch ($this->description) {
            case 'credit':
                return $this->belongsTo(Deposit::class, 'transaction_id');
                break;
            case 'commission':
                return $this->belongsTo(Commission::class, 'transaction_id');
                break;
            default:
                return $this->belongsTo(Withdrawal::class, 'transaction_id');
                break;
        }
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'transaction_by')->withTrashed();
    }

    public function getDateAttribute()
    {
        return date('l F d, Y', strtotime($this->transaction_date));
    }
}
