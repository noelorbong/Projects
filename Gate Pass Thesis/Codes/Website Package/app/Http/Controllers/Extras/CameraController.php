<?php

namespace App\Http\Controllers\Extras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CameraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
       
        return view('extras.camera');
    }

    public function ipCamera()
    {
        $ip_camera = DB::table('ip_camera')
        ->select(
            DB::raw(
                'ip_camera.*'))
        ->first();
       
        return compact('ip_camera');
    }

    public function updateCamera($ip){

        DB::table('ip_camera')
            ->update(['ip_address' => $ip, 
            'updated_at' => DB::raw('NOW()')
            ]);
        
        return 'success';
    }

    public function getPlate()
    {
        $plate_detected = DB::table('plate_detected')
        ->select(
            DB::raw(
                'plate_detected.*'))
        ->first();
       
        return compact('plate_detected');
    }
    


}
