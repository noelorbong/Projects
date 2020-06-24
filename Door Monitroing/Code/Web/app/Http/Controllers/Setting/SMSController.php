<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function smsSetting(){
        $messages = DB::table('sms_setting')
            ->select('*')
            ->first();

        return compact('messages');
    }

    public function smsUpdate(Request $request)
    {
        DB::table('sms_setting')
        ->update(
            ['enable' => (boolean)$request->enable,
            'message_out' => $request->message_out]
        );
        return back();
    }
}
