<?php

namespace App\Http\Controllers\Students;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($id){
        return view('pagesstudents.register');
    }

    public function takeDataset($id){
           
        DB::table('datasetcmd')->insert(
            ['face_id' => $id]
        );

        DB::table('profiles')
        ->where('id', $id)
        ->update(
            ['registered' => 1]
        );

        return "success";
    }

    public function regCount(){
           
        $count = DB::table('datasetcmd')->count();
        $student_id = 0;
        if($count!=0){
            $student_id =  DB::table('datasetcmd')->first()->face_id;
        }
        $student = DB::table('profiles')->where('id', $student_id)->first();
       

        return compact('count','student');
    }
}
