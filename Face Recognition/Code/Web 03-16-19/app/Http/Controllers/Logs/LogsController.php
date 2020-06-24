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

    public function popLog(){
        return view('pageslogs.studentpop');
    }

    public function selectLastLog(){
        $records1 = DB::table('profile_logs')
        ->select('*')
        ->orderByRaw('profile_logs.id desc')
        ->first();

        $id = $records1->user_id;

        $records2 = DB::table('profiles')
        ->select('*')
        ->orderByRaw('profiles.id desc')
        ->where('id','=', $id)
        ->first();

        return compact(['records1','records2']);
    }

    public function selectLogs($startdate, $enddate){
        $records = DB::table('profile_logs')
        ->select('*')
        ->where(DB::raw('Date(created_at)'),'>=', $startdate)
        ->where(DB::raw('Date(created_at)'),'<=', $enddate)
        ->orderByRaw('profile_logs.id desc')
        ->get();

        return compact('records');
    }

    public function printLogs($startdate, $enddate){
        $records = DB::table('profile_logs')
        ->select('*')
        ->where(DB::raw('Date(created_at)'),'>=', $startdate)
        ->where(DB::raw('Date(created_at)'),'<=', $enddate)
        ->orderByRaw('profile_logs.id desc')
        ->get();

        return view('print', compact('records'));
    }


    public function selectSMSLogs($startdate, $enddate){
        $records = DB::table('sent_messages')
        ->select('*')
        ->where(DB::raw('Date(created_at)'),'>=', $startdate)
        ->where(DB::raw('Date(created_at)'),'<=', $enddate)
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

    
    public function listGrade(){

        $grade_levels = DB::table('profiles')
        ->select('grade_level')
        ->orderByRaw('profiles.grade_level asc')
        ->groupBy('grade_level')
        ->get();

        // return $grade_levels;
        return view('pageslogs.listgrade', compact('grade_levels'));
    }
    
    public function listSection($grade_level){

        $sections = DB::table('profiles')
        ->select('section')
        ->orderByRaw('profiles.section asc')
        ->groupBy('section')
        ->where('grade_level','=', $grade_level)
        ->get();

        // return $grade_levels;
        return view('pageslogs.listsection', compact(['sections','grade_level']));
    } 

    public function listSectionIndex($grade_level,$section){

        // return $grade_levels;
        return view('pageslogs.studentgradelog', compact(['section','grade_level']));
    } 

    public function listUnknownLog(){

        // return $grade_levels;
        return view('pageslogs.unknownlog');
    } 

    
    public function listSectionStudents($grade_level,$section,$startdate,$enddate ){
        $records = DB::table('profile_logs')
        ->select('*')
        ->where('grade_level','=', $grade_level)
        ->where('section','=', $section)
        ->where(DB::raw('Date(created_at)'),'>=', $startdate)
        ->where(DB::raw('Date(created_at)'),'<=', $enddate)
        ->orderByRaw('profile_logs.id desc')
        ->get();

        return compact('records');
    }

    public function printSectionLogs($grade_level,$section,$startdate, $enddate){
        $records = DB::table('profile_logs')
        ->select('*')
        ->where('grade_level','=', $grade_level)
        ->where('section','=', $section)
        ->where(DB::raw('Date(created_at)'),'>=', $startdate)
        ->where(DB::raw('Date(created_at)'),'<=', $enddate)
        ->orderByRaw('profile_logs.id desc')
        ->get();

        return view('printsection', compact('records'));
    }

    
}
