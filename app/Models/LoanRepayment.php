<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo(User::class, 'entered_by')->withTrashed();
    }

    public function getDateAttribute()
    {
        return date('l F d, Y', strtotime($this->repayment_date));
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
