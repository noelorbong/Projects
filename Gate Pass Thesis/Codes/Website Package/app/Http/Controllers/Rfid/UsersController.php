<?php

namespace App\Http\Controllers\Rfid;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $rfidusers = DB::table('rfidaccounts')
        ->select(
            DB::raw(
                'rfidaccounts.*,
                (select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) as state'))
        ->orderByRaw('account_name ASC')
        ->get();
        return view('rfid.userlist', compact('rfidusers'));
    }

    public function addView()
    {
        
        return view('rfid.useradd');
    }

    public function storeRfidAccount(Request $request)
    {

        DB::table('rfidaccounts')->insert(
            ['created_by_user' => Auth::user()->id, 
            'user_type' => $request->user_type,
            'rfid_no' => $request->rfid_no,
            'account_name' => $request->account_name,
            'house_address' => $request->house_address,
            'plate_no' => $request->plate_no
            ]
        );
        
        return redirect('/userlist');
    }

    public function updateRfidAccount(Request $request,$id){

        DB::table('rfidaccounts')
            ->where('id', $id)
            ->update(['updated_by_user' => Auth::user()->id, 
            'user_type' => $request->user_type,
            'rfid_no' => $request->rfid_no,
            'account_name' => $request->account_name,
            'house_address' => $request->house_address,
            'plate_no' => $request->plate_no,
            'updated_at' => DB::raw('NOW()')
            ]);
        
        return redirect('/userlist');
    }

    public function editAccount($id){
        $rfiduser = DB::table('rfidaccounts')->where('id', $id)->first();
        
        return view('rfid.useredit', compact('rfiduser'));
    }

    public function deleteAccount($id){
        DB::table('rfidaccounts')->where('id', '=', $id)->delete();

        return 'success';
    }

    public function searchRfid($search){
        $rfidusers = DB::table('rfidaccounts')
        ->select(
            DB::raw(
                'rfidaccounts.*,
                (select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) as state'))
        ->orderByRaw('account_name ASC')
        ->where('rfidaccounts.created_at', 'LIKE', '%' . $search . '%')
        ->orWhere('rfidaccounts.user_type', 'LIKE', '%' .  $search. '%')
        ->orWhere('rfidaccounts.rfid_no', 'LIKE', '%' .  $search. '%')
        ->orWhere('rfidaccounts.account_name', 'LIKE', '%' .  $search. '%')
        ->orWhere('rfidaccounts.house_address', 'LIKE', '%' .  $search. '%')
        ->orWhere('rfidaccounts.plate_no', 'LIKE', '%' .  $search. '%')

        ->get();

        // return $rfidusers;
        return view('rfid.userlist', compact('rfidusers'));

    }

    public function searchLogSort($search, $sortcolum,$sort)
    {
        if ($sortcolum == 'state')
        {
            $rfidusers = DB::table('rfidaccounts')
            ->select(
                DB::raw(
                    'rfidaccounts.*,
                    (select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) as state'))
            ->where('rfidaccounts.created_at', 'LIKE', '%' . $search . '%')
            ->orWhere('rfidaccounts.user_type', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.rfid_no', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.account_name', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.house_address', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.plate_no', 'LIKE', '%' .  $search. '%')
            ->orderByRaw('(select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) '.$sort)
            ->get();
        }else{
            $rfidusers = DB::table('rfidaccounts')
            ->select(
                DB::raw(
                    'rfidaccounts.*,
                    (select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) as state'))
            ->where('rfidaccounts.created_at', 'LIKE', '%' . $search . '%')
            ->orWhere('rfidaccounts.user_type', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.rfid_no', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.account_name', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.house_address', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.plate_no', 'LIKE', '%' .  $search. '%')
            ->orderByRaw('rfidaccounts.'.$sortcolum.' '.$sort)
            ->get();
        }
        return compact('rfidusers');
    } 
    
    public function sortRfid($sortcolum,$sort)
    {
        if ($sortcolum == 'state')
        {
            $rfidusers = DB::table('rfidaccounts')
            ->select(
                DB::raw(
                    'rfidaccounts.*,
                    (select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) as state'))
                ->orderByRaw('(select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) '.$sort)
            ->get();
            
            }else{
            $rfidusers = DB::table('rfidaccounts')
            ->select(
                DB::raw(
                    'rfidaccounts.*,
                    (select rf.state from rfid_account_logs rf where rf.rfid_no = rfidaccounts.rfid_no order by id desc limit 1) as state'))
                ->orderByRaw('rfidaccounts.'.$sortcolum.' '.$sort)
            ->get();
            }

        return compact('rfidusers');
    }  


}
