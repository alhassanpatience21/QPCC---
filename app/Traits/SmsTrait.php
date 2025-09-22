<?php

namespace App\Traits;

use App\Models\SmsLogger;
use App\Models\SmsSetting;
use Carbon\Carbon;

trait SmsTrait
{
    public $key;
    public $message;
    public $numbers;
    public $sender;
    private $url;

    public function __construct()
    {
        $endPoint = 'https://api.mnotify.com/api/sms/quick';
        $apiKey = 'TW8jtrv7E9JdNeB4H0566Ijd3McRkjiegqxJS2RwcAKZO';
        $this->url = $endPoint . '?key=' . $apiKey;
        $this->sender = "KL Susu";
    }

    public function sendMessage()
    {
        $data = [
            'recipient'     => array($this->numbers),
            'sender'        => $this->sender,
            'message'       => $this->message,
            'is_schedule'   => 'false',
            'schedule_date' => ''
        ];

        $ch = curl_init();
        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        return $result = json_decode($result, TRUE);
        curl_close($ch);
    }

    public function collector($message, $number)
    {
        $smsSettings = SmsSetting::first();

        if ($smsSettings->can_send_message) {
            $this->message = $message;
            $this->numbers = $number;

            if ($status = $this->sendMessage()) {
                return $this->logSms($message, $number, $status);
            }
        }
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

        $smsSettings = SmsSetting::first();
        $smsSettings->credits -= $status['summary']['credit_used'];
        return $smsSettings->saveOrFail();
    }
}
