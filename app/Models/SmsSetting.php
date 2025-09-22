<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    use HasFactory;

    public function getHasCreditAttribute()
    {
        return ($this->credits) ? true : false;
    }

    public function getMessageStatusAttribute()
    {
        return ($this->send_messages) ? true : false;
    }

    public function getCanSendMessageAttribute()
    {
        return ($this->has_credit && $this->message_status) ? true : false;
    }
}
