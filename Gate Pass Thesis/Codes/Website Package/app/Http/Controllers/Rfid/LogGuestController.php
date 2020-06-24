<?php

namespace App\Http\Controllers\Rfid;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogGuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $rfidusers = DB::table('rfid_account_logs')
        ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
        ->select(
            DB::raw(
                'rfid_account_logs.*,
                rfidaccounts.user_type,
                rfidaccounts.created_by_user,
                rfidaccounts.updated_by_user,
                rfidaccounts.account_name,
                rfidaccounts.house_address,
                rfidaccounts.plate_no'))
        
        ->orderByRaw('rfid_account_logs.id DESC')
        ->where(function($query) {
            $query->where('rfidaccounts.user_type', '!=', 'Owner')
            ->orWhereNull('rfidaccounts.user_type');
        })
        ->get();
        return view('rfid.logguest', compact('rfidusers'));
    }
    
    public function searchLog($search)
    {
        $rfidusers = DB::table('rfid_account_logs')
        ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
        ->select(
            DB::raw(
                'rfid_account_logs.*,
                rfidaccounts.user_type,
                rfidaccounts.created_by_user,
                rfidaccounts.updated_by_user,
                rfidaccounts.account_name,
                rfidaccounts.house_address,
                rfidaccounts.plate_no'))
        ->orderByRaw('rfid_account_logs.id DESC')
        ->where(function($query) {
            $query->where('rfidaccounts.user_type', '!=', 'Owner')
            ->orWhereNull('rfidaccounts.user_type');
        })
        ->where(function($query) use ($search) {
            $query->where('rfid_account_logs.created_at', 'LIKE', '%' . $search . '%')
            ->orWhere('rfid_account_logs.state', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfid_account_logs.rfid_no', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.account_name', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.house_address', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.plate_no', 'LIKE', '%' .  $search. '%')
            ->orWhere('rfidaccounts.user_type', 'LIKE', '%' .  $search. '%');
        })
        ->get();
        // ->paginate(8);

        // return $rfidusers;
        return view('rfid.logguest', compact('rfidusers'));
    }
    
    public function searchLogSort($search, $sortcolum,$sort)
    {
        if ($sortcolum == 'user_type' || $sortcolum == 'account_name' || $sortcolum == 'house_address' || $sortcolum == 'plate_no')
        {
            $rfidusers = DB::table('rfid_account_logs')
            ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
            ->select(
                DB::raw(
                    'rfid_account_logs.*,
                    rfidaccounts.user_type,
                    rfidaccounts.created_by_user,
                    rfidaccounts.updated_by_user,
                    rfidaccounts.account_name,
                    rfidaccounts.house_address,
                    rfidaccounts.plate_no'))
             ->where(function($query) {
                    $query->where('rfidaccounts.user_type', '!=', 'Owner')
                    ->orWhereNull('rfidaccounts.user_type');
                })
            ->where(function($query) use ($search) {
                $query->where('rfid_account_logs.created_at', 'LIKE', '%' . $search . '%')
                ->orWhere('rfid_account_logs.state', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfid_account_logs.rfid_no', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.account_name', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.house_address', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.plate_no', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.user_type', 'LIKE', '%' .  $search. '%');
            })
            ->orderByRaw('rfidaccounts.'.$sortcolum.' '.$sort)
            ->get();
        }else{
            $rfidusers = DB::table('rfid_account_logs')
            ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
            ->select(
                DB::raw(
                    'rfid_account_logs.*,
                    rfidaccounts.user_type,
                    rfidaccounts.created_by_user,
                    rfidaccounts.updated_by_user,
                    rfidaccounts.account_name,
                    rfidaccounts.house_address,
                    rfidaccounts.plate_no'))
             ->where(function($query) {
                $query->where('rfidaccounts.user_type', '!=', 'Owner')
                ->orWhereNull('rfidaccounts.user_type');
            })
            ->where(function($query) use ($search) {
                $query->where('rfid_account_logs.created_at', 'LIKE', '%' . $search . '%')
                ->orWhere('rfid_account_logs.state', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfid_account_logs.rfid_no', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.account_name', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.house_address', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.plate_no', 'LIKE', '%' .  $search. '%')
                ->orWhere('rfidaccounts.user_type', 'LIKE', '%' .  $search. '%');
            })
            ->orderByRaw('rfid_account_logs.'.$sortcolum.' '.$sort)
            ->get();
        }
        return compact('rfidusers');
    } 
    
    public function sortRfid($sortcolum,$sort)
    {
        if ($sortcolum == 'user_type' || $sortcolum == 'account_name' || $sortcolum == 'house_address' || $sortcolum == 'plate_no')
        {
            $rfidusers = DB::table('rfid_account_logs')
            ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
            ->select(
                DB::raw(
                    'rfid_account_logs.*,
                    rfidaccounts.user_type,
                    rfidaccounts.created_by_user,
                    rfidaccounts.updated_by_user,
                    rfidaccounts.account_name,
                    rfidaccounts.house_address,
                    rfidaccounts.plate_no'))
            
            ->orderByRaw('rfidaccounts.'.$sortcolum.' '.$sort)
            ->where(function($query) {
                $query->where('rfidaccounts.user_type', '!=', 'Owner')
                ->orWhereNull('rfidaccounts.user_type');
            })
            ->get();
            }else{
                $rfidusers = DB::table('rfid_account_logs')
                ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
                ->select(
                    DB::raw(
                        'rfid_account_logs.*,
                        rfidaccounts.user_type,
                        rfidaccounts.created_by_user,
                        rfidaccounts.updated_by_user,
                        rfidaccounts.account_name,
                        rfidaccounts.house_address,
                        rfidaccounts.plate_no'))
                
                ->orderByRaw('rfid_account_logs.'.$sortcolum.' '.$sort)
                ->where(function($query) {
                    $query->where('rfidaccounts.user_type', '!=', 'Owner')
                    ->orWhereNull('rfidaccounts.user_type');
                })
                ->get();
            }

        return compact('rfidusers');
    }  

    public function deleteLog($id){
        DB::table('rfid_account_logs')->where('id', '=', $id)->delete();
        return 'success';
    }

    public function currentLog(){
        
        $rfiduserin = DB::table('rfid_account_logs')
        ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
        ->select(
            DB::raw(
                'rfid_account_logs.*,
                rfidaccounts.user_type,
                rfidaccounts.created_by_user,
                rfidaccounts.updated_by_user,
                rfidaccounts.account_name,
                rfidaccounts.house_address,
                rfidaccounts.plate_no'))
        
        ->orderByRaw('rfid_account_logs.id DESC ')
        ->where(function($query) {
            $query->where('rfidaccounts.user_type', '!=', 'Owner')
            ->orWhereNull('rfidaccounts.user_type');
        })
        ->where('state', '=', 1)
        ->first();

        $rfiduserout = DB::table('rfid_account_logs')
        ->leftJoin('rfidaccounts', 'rfid_account_logs.user_id', '=', 'rfidaccounts.id')
        ->select(
            DB::raw(
                'rfid_account_logs.*,
                rfidaccounts.user_type,
                rfidaccounts.created_by_user,
                rfidaccounts.updated_by_user,
                rfidaccounts.account_name,
                rfidaccounts.house_address,
                rfidaccounts.plate_no'))
        
        ->orderByRaw('rfid_account_logs.id DESC ')
        ->where(function($query) {
            $query->where('rfidaccounts.user_type', '!=', 'Owner')
            ->orWhereNull('rfidaccounts.user_type');
        })
        ->where('state', '=', 0)
        ->first();

        return compact(['rfiduserin', 'rfiduserout']);
    }


}
