<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function getData($account)
    {
        $account = Account::where('account_number', $account)->first();
        return response()->json([
            'amount'                 => $account->payment_amount,
            'balance'                => $account->actual_balance,
            'commission'             => $account->commission_withdrawal,
            'photo'                  => $account->profile_photo,
            'susu'                   => $account->susu_account,
            'savings'                => $account->savings_account,
            'max'                    => ($account->actual_balance - $account->commission_withdrawal),
        ]);
    }
}
