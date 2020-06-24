<?php

namespace App\Http\Controllers\SMS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('sms.list');
    }

    public function list($sortcolum,$sort ){
        $records = DB::table('sms_subscribers')
            ->select('*')
            ->orderByRaw('sms_subscribers.'.$sortcolum.' '.$sort)
            ->get();
    
        return compact('records');
    }

    public function add(){
        return view('sms.add');
    }

    public function store(Request $request)
    {
 
        DB::table('sms_subscribers')->insert(
            ['name' => $request->name,
            'number' => $request->number,
            'active' => (boolean)$request->active
            ]
        );
        return redirect('/smslist');
    }

    public function edit($id){
        $subscriber =  DB::table('sms_subscribers')->where('id', $id)->first();

        return view('sms.edit', compact('subscriber'));
    }

    public function update(Request $request)
    {
        DB::table('sms_subscribers')
        ->where('id', $request->id)
        ->update(
            ['name' => $request->name,
            'number' => $request->number,
            'active' => (boolean)$request->active
            ]
        );
        return redirect('/smslist');
    }

    public function search($search){
        $records = DB::table('sms_subscribers')
        ->select('*')
        ->where('sms_subscribers.name','LIKE','%'.$search.'%')
        ->orWhere('sms_subscribers.number', 'LIKE', '%' .  $search. '%')
        ->orWhere('sms_subscribers.active', 'LIKE', '%' .  $search. '%')
        ->orWhere('sms_subscribers.created_at', 'LIKE', '%' .  $search. '%')
        ->orderByRaw('sms_subscribers.name asc')
        ->get();

        return compact('records');
    }

    public function updateStatus($id,$status)
    {
        DB::table('sms_subscribers')
        ->where('id',$id)
        ->update(
            ['active' => (boolean)$status]
        );
        return 'success';
    }

    public function delete($id){
        DB::table('sms_subscribers')->where('id', '=', $id)->delete();

        return 'success';
    }

}
