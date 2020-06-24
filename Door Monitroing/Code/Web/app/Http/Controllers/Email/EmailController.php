<?php

namespace App\Http\Controllers\Email;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('email.list');
    }

    public function list($sortcolum,$sort ){
        $records = DB::table('email_subscribers')
            ->select('*')
            ->orderByRaw('email_subscribers.'.$sortcolum.' '.$sort)
            ->get();
    
        return compact('records');
    }

    public function add(){
        return view('email.add');
    }

    public function store(Request $request)
    {
 
        DB::table('email_subscribers')->insert(
            ['name' => $request->name,
            'email' => $request->email,
            'active' => (boolean)$request->active
            ]
        );
        
        return redirect('/emaillist');
    }

    public function edit($id){
        $subscriber =  DB::table('email_subscribers')->where('id', $id)->first();

        return view('email.edit', compact('subscriber'));
    }

    public function update(Request $request)
    {
        DB::table('email_subscribers')
        ->where('id', $request->id)
        ->update(
            ['name' => $request->name,
            'email' => $request->email,
            'active' => (boolean)$request->active
            ]
        );
        return redirect('/emaillist');
    }

    public function search($search){
        $records = DB::table('email_subscribers')
        ->select('*')
        ->where('email_subscribers.name','LIKE','%'.$search.'%')
        ->orWhere('email_subscribers.email', 'LIKE', '%' .  $search. '%')
        ->orWhere('email_subscribers.active', 'LIKE', '%' .  $search. '%')
        ->orWhere('email_subscribers.created_at', 'LIKE', '%' .  $search. '%')
        ->orderByRaw('email_subscribers.name asc')
        ->get();

        return compact('records');
    }

    public function updateStatus($id,$status)
    {
        DB::table('email_subscribers')
        ->where('id',$id)
        ->update(
            ['active' => (boolean)$status]
        );
        return 'success';
    }

    public function delete($id){
        DB::table('email_subscribers')->where('id', '=', $id)->delete();

        return 'success';
    }

}
