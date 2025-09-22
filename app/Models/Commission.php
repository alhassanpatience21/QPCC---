<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    // types of commission
    public const PASS_BOOK = 'pass book';
    public const PASS_BOOK_FEE = 5;
    public const MONTHLY_SMS_FEE = 1;
    public const MONTHLY_SMS = 'monthly sms fee';
    public const DEPOSIT = 'deposit';
    public const WITHDRAWAL = 'withdrawal';

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'entered_by')->withTrashed();
    }

    public function getDateAttribute()
    {
        return date('l F d, Y', strtotime($this->created_at));
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'entered_by')->withTrashed();
    }
}
