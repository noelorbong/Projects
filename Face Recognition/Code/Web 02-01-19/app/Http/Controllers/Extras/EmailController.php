<?php

namespace App\Http\Controllers\Extras;

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

    public function store(Request $request)
    {
        DB::table('send_email')->insert(
            ['receipient' => $request->receipient,
            'date' => $request->date,
            'end_date' => $request->end_date,
            'type' => (boolean)$request->type,
            'grade_level' => $request->grade_level,
            'section' => $request->section
            ]
        );
        
        return 'success';
    }

    public function emailUpdate(Request $request){
        DB::table('email_setting')
        ->update(
            ['sender' => $request->sender,
            'sender_password' => $request->sender_password,
            'recipient' => $request->recipient,
            'subject' => $request->subject,
            'enable' => $request->enable,
            'send_time' => $request->send_time
            ]
        );
        return back();
    }

}
