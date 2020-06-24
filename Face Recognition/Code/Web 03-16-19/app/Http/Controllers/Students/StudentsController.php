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
        ->orWhere('profiles.grade_level', 'LIKE', '%' .  $search. '%')
        ->orWhere('profiles.section', 'LIKE', '%' .  $search. '%')
        ->orWhere('profiles.created_at', 'LIKE', '%' .  $search. '%')
        ->orderByRaw('profiles.name desc')
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
            'gender' => (boolean)$request->gender,
            'grade_level' => $request->grade_level,
            'section' => $request->section,
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
            'gender' => (boolean)$request->gender,
            'grade_level' => $request->grade_level,
            'section' => $request->section,
            'dob' => $request->dob,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address
            ]
        );
        
        return redirect('/studentlist');
    }

    public function delete($id){
        //
        $x = 1;
        $name_string = '';
        while($x <= 10) {
            $name_string = 'img/dataset/User.'.$id.'.'.$x.'.jpg';
            if(\File::exists(public_path($name_string))){
                \File::delete(public_path($name_string));
              }else{
                // dd('File does not exists.');
              }
            $x++;
        } 

        DB::table('profiles')->where('id', '=', $id)->delete();

        

        return 'success';
    }

    public function listGrade(){

        $grade_levels = DB::table('profiles')
        ->select('grade_level')
        ->orderByRaw('profiles.grade_level asc')
        ->groupBy('grade_level')
        ->get();

        // return $grade_levels;
        return view('pagesstudents.listgrade', compact('grade_levels'));
    }
    
    public function listSection($grade_level){

        $sections = DB::table('profiles')
        ->select('section')
        ->orderByRaw('profiles.section asc')
        ->groupBy('section')
        ->where('grade_level','=', $grade_level)
        ->get();

        // return $grade_levels;
        return view('pagesstudents.listsection', compact(['sections','grade_level']));
    } 

    public function listSectionIndex($grade_level,$section){

        // return $grade_levels;
        return view('pagesstudents.listsectionstudents', compact(['section','grade_level']));
    } 

    public function listSectionStudents($grade_level,$section ){
        $studentlist = DB::table('profiles')
        ->select('*')
        ->orderByRaw('profiles.name asc')
        ->where('grade_level','=', $grade_level)
        ->where('section','=', $section)
        ->get();

        return compact('studentlist');
    }

    public function searchListSectionStudents($grade_level,$section,$search){

        $studentlist = DB::table('profiles')
        ->select('*')
        ->where('profiles.grade_level','=', $grade_level)
        ->where('profiles.section','=', $section)
        ->where(function($query) use ($search) {
            $query->where('profiles.name','LIKE','%'.$search.'%')
            ->orWhere('profiles.dob', 'LIKE', '%' .  $search. '%')
            ->orWhere('profiles.mobile_number', 'LIKE', '%' .  $search. '%')
            ->orWhere('profiles.address', 'LIKE', '%' .  $search. '%')
            ->orWhere('profiles.grade_level', 'LIKE', '%' .  $search. '%')
            ->orWhere('profiles.section', 'LIKE', '%' .  $search. '%')
            ->orWhere('profiles.created_at', 'LIKE', '%' .  $search. '%');
        })
        
        ->orderByRaw('profiles.name desc')
        ->get();

        return compact('studentlist');
    }
    
}
