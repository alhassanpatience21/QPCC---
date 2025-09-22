<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Commission;
use App\Models\AccountTrialBalance;

trait LogCommission
{
    public function logCommission($account, $amount, $type)
    {
        $commission = new Commission();
        $commission->account_number = $account->account_number;
        $commission->amount = $amount;
        $commission->source = $type;
        $commission->entered_by = auth()->id() ?? 1;
        $commission->account_type = $account->account_type;
        $commission->transaction_date = Carbon::today();
        $commission->saveOrFail();

        if ($type != Commission::PASS_BOOK) {
            $trailBalance = new AccountTrialBalance();
            $trailBalance->transaction_date = Carbon::today();
            $trailBalance->transaction_id = $commission->id;
            $trailBalance->amount = $commission->amount;
            $trailBalance->account_type = $commission->account_type;
            $trailBalance->account_number = $commission->account_number;
            $trailBalance->balance = floatval(preg_replace('/[^\d.]/', '', $commission->account->actual_balance));
            $trailBalance->description = $type == Commission::MONTHLY_SMS ? Commission::MONTHLY_SMS : 'commission';
            $trailBalance->transaction_by = auth()->id() ?? 1;
            $trailBalance->saveOrFail();
        }

        return $commission->amount;
    }
}
