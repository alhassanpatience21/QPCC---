<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo(User::class, 'entered_by')->withTrashed();
    }

    public function getDateAttribute()
    {
        return date('l F d, Y', strtotime($this->date_of_withdrawal));
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'entered_by')->withTrashed();
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 1);
    }

    // public function commission()
    // {
    //     return $this->hasOne(Commission::class, 'transaction_id', 'id')->where('description', 'commission');
    // }

    // public function commission()
    // {
    //     return $this->hasOne(Commission::class, 'transaction_id', 'id')->where('description', 'commission');
    // }
}
