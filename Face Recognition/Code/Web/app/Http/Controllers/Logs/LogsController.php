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

    public function index(){
        return view('pageslogs.studentlog');
    }

    public function smsLogIndex(){
        return view('pageslogs.smslog');
    }

    public function report(){
        return view('pageslogs.report');
    }

    public function selectLogs($startdate, $enddate){
        $records = DB::table('profile_logs')
        ->select('*')
        ->where('created_at','>=', $startdate)
        ->where('created_at','<', $enddate)
        ->orderByRaw('profile_logs.id desc')
        ->get();

        return compact('records');
    }

    public function printLogs($startdate, $enddate){
        $records = DB::table('profile_logs')
        ->select('*')
        ->where('created_at','>=', $startdate)
        ->where('created_at','<', $enddate)
        ->orderByRaw('profile_logs.id desc')
        ->get();

        return view('print', compact('records'));
    }


    public function selectSMSLogs($startdate, $enddate){
        $records = DB::table('sent_messages')
        ->select('*')
        ->where('created_at','>=', $startdate)
        ->where('created_at','<', $enddate)
        ->orderByRaw('sent_messages.id desc')
        ->get();

        return compact('records');
    }

    public function countInOut($date){
        $rfidin = DB::table('profile_logs')
        ->select(
            DB::raw(
                'COUNT(*) as total_in'))
        ->where('status', '=', 1)
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->first();

        $rfidout = DB::table('profile_logs')
        ->select(
            DB::raw(
                'COUNT(*) as total_out'))
        ->where('status', '=', 0)
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->first();

        $rfidcurinout = DB::table('profile_logs')
        ->select(
            DB::raw(
                'profile_logs.user_id,
                (select rf.status from profile_logs rf where rf.user_id = profile_logs.user_id order by id desc limit 1) as curstate'))
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->distinct()->get(['user_id']);


         return compact('rfidin', 'rfidout', 'rfidcurinout');
    }

    public function currentLog(){
        
        $studentin = DB::table('profile_logs')
        ->select(
            DB::raw(
                'profile_logs.*'))
        ->orderByRaw('profile_logs.id DESC ')
        ->where('status', '=', 1)
        ->first();

        $studentinout = DB::table('profile_logs')
        ->select(
            DB::raw(
                'profile_logs.*'))
        ->orderByRaw('profile_logs.id DESC ')
        ->where('status', '=', 0)
        ->first();

        return compact(['studentin', 'studentinout']);
    }
}
