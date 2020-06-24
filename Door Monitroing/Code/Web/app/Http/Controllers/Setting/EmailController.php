<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function emailSetting(){
        $messages = DB::table('email_setting')
            ->select('*')
            ->first();

        return compact('messages');
    }

    public function emailUpdate(Request $request)
    {
        DB::table('email_setting')
        ->update(
            ['enable' => (boolean)$request->enable,
            'sender' => $request->sender,
            'sender_password' => $request->sender_password,
            'subject' => $request->subject
            ]
        );
        return back();
    }
}
