<?php

namespace App\Http\Controllers\Rfid;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
       
        return view('rfid.report');
    }

    public function countInOut($date){
        $rfidin = DB::table('rfid_account_logs')
        ->select(
            DB::raw(
                'COUNT(*) as total_in'))
        ->where('state', '=', 1)
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->first();

        $rfidout = DB::table('rfid_account_logs')
        ->select(
            DB::raw(
                'COUNT(*) as total_out'))
        ->where('state', '=', 0)
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->first();

        $rfidcurinout = DB::table('rfid_account_logs')
        ->select(
            DB::raw(
                'rfid_account_logs.rfid_no,
                (select rf.state from rfid_account_logs rf where rf.rfid_no = rfid_account_logs.rfid_no order by id desc limit 1) as curstate'))
        ->where( DB::raw('DATE(created_at)'), '=', $date)
        ->distinct()->get(['rfid_no']);


         return compact('rfidin', 'rfidout', 'rfidcurinout');
    }


      
}
