<?php

namespace App\Http\Controllers\Extras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        return view('pagesextras.sms');
    }

    public function pendingList(){
        $messages = DB::table('messages')
        ->select('*')
        ->orderByRaw('messages.id asc')
        ->get();

        return compact('messages');
    }

    public function smsSetting(){
        $messages = DB::table('sms_setting')
        ->select('*')
        ->first();

        return compact('messages');
    }

    public function smsUpdate(Request $request){
        DB::table('sms_setting')
        ->update(
            ['enable' => $request->enable,
            'message_out' => $request->message_out,
            'message_in' => $request->message_in
            ]
        );
        return back();
    }

}
