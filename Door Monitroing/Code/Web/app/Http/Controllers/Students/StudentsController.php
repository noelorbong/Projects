<?php

namespace App\Http\Controllers\Students;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('pagesstudents.list');
    }

    public function profile($id){
        $student =  DB::table('profiles')->where('id', $id)->first();

        $records = DB::table('profile_logs')
        ->select('*')
        ->where('user_id','=', $id)
        ->orderByRaw('profile_logs.id desc')
        ->get();

        return view('pagesstudents.profile', compact('student','records'));
    }

    public function add(){
        return view('pagesstudents.add');
    }

    //API
    public function list($sortcolum,$sort ){
        $studentlist = DB::table('profiles')
        ->select('*')
        ->orderByRaw('profiles.'.$sortcolum.' '.$sort)
        ->get();

        return compact('studentlist');
    }

    public function search($search){
        $studentlist = DB::table('profiles')
        ->select('*')
        ->where('profiles.name','LIKE','%'.$search.'%')
        ->orWhere('profiles.dob', 'LIKE', '%' .  $search. '%')
        ->orWhere('profiles.mobile_number', 'LIKE', '%' .  $search. '%')
        ->orWhere('profiles.address', 'LIKE', '%' .  $search. '%')
        ->orderByRaw('profiles.created_at desc')
        ->get();

        return compact('studentlist');
    }

    public function edit($id){
        $student =  DB::table('profiles')->where('id', $id)->first();

        return view('pagesstudents.edit', compact('student'));
        // return compact('student');
    }

    public function store(Request $request)
    {
        DB::table('profiles')->insert(
            ['name' => $request->name,
            'dob' => $request->dob,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address
            ]
        );
        
        return redirect('/studentlist');
    }

    public function update(Request $request)
    {
        DB::table('profiles')
        ->where('id', $request->id)
        ->update(
            ['name' => $request->name,
            'dob' => $request->dob,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address
            ]
        );
        
        return redirect('/studentlist');
    }
}
