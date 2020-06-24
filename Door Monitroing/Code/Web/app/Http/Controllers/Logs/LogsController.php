<?php

namespace App\Http\Controllers\Logs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function emailLogIndex(){
        return view('log.emaillog');
    }

    public function smsLogIndex(){
        return view('log.smslog');
    }

    public function sensorLogIndex(){
        return view('log.sensorlog');
    }

    public function selectEmailLog($startdate, $enddate){
        $records = DB::table('email_log')
        ->select('*')
        ->where('created_at','>=', $startdate)
        ->where('created_at','<', $enddate)
        ->orderByRaw('email_log.id desc')
        ->get();

        return compact('records');
    }


    public function selectSMSLog($startdate, $enddate){
        $records = DB::table('sms_log')
        ->select('*')
        ->where('created_at','>=', $startdate)
        ->where('created_at','<', $enddate)
        ->orderByRaw('sms_log.id desc')
        ->get();

        return compact('records');
    }

    public function selectSensorLog($startdate, $enddate){
        $records = DB::table('instace_counter')
        ->select('*')
        ->where('created_at','>=', $startdate)
        ->where('created_at','<', $enddate)
        ->orderByRaw('instace_counter.id desc')
        ->get();

        return compact('records');
    }

    public function countAllLog($date){
        $email = DB::table('email_log')
        ->select(
            DB::raw(
                'COUNT(*) as count'))
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->first();

        $sms = DB::table('sms_log')
        ->select(
            DB::raw(
                'COUNT(*) as count'))
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->first();

        $sensor = DB::table('instace_counter')
        ->select(
            DB::raw(
                'COUNT(*) as count'))
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->first();

        return compact('email', 'sms', 'sensor');
    }

 

}
