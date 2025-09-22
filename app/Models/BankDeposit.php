<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    use HasFactory;

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id', 'account_number');
    }
}
