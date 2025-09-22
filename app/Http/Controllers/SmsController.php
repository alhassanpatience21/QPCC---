<?php

namespace App\Http\Controllers;

use App\Models\SmsLogger;
use App\Models\SmsSetting;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function index(Request $request)
    {
        $settings = SmsSetting::first();
        if ($request->query('type')) {
            $settings->send_messages = $request->type == 'enable' ? 1 : 0;
            $settings->saveOrFail();
        }

        $sms = SmsLogger::latest()->get();
        return view('sms.index', compact('sms', 'settings'));
    }
}
