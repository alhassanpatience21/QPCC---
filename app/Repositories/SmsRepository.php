<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Traits\SmsTrait;
use App\Models\SmsLogger;
use App\Models\SmsSetting;

class SmsRepository
{
    use SmsTrait;

    public function sendSmsNotification($account, $amount, $type)
    {
        $number = $account->phone_number_one;
        $message = 'Dear ' . $account->full_name . ', your account (' . $account->account_number . ') has been ' . $type . ' with GHS ' . number_format($amount, 2) . ' on ' . Carbon::now() . '. Balance: ' . $account->balance . '. Helpline:+233 24 444 8865';
        return $this->collector($message, $number);
    }

    public function logSms($message, $number, $status)
    {
        $sms = new SmsLogger();
        $sms->date_sent = Carbon::today();
        $sms->recepient = $number;
        $sms->message = $message;
        $sms->credits = $status['summary']['credit_used'];
        $sms->status = $status['code'];
        $sms->saveOrFail();

        return $this->deductBalance($sms->credits);
    }

    public function deductBalance($credits)
    {
        $smsSettings = SmsSetting::first();
        $smsSettings->credits -= $credits;
        return $smsSettings->saveOrFail();
    }

    public function smsLogs()
    {
        return SmsLogger::latest()->get();
    }
}
