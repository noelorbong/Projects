<?php

namespace App\Http\Controllers\Extras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DevicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pagesextras.devices');
    }

    public function deviceState()
    {
        $fan = DB::table('fan')
        ->select('*')
        ->orderByRaw('id DESC')
        ->limit(1)
        ->get();

        $alarm = DB::table('alarm')
        ->select('*')
        ->orderByRaw('id DESC')
        ->limit(1)
        ->get();

         return compact(['fan','alarm']);
    }

    public function deviceSetting(){
        $device = DB::table('device_setting')
            ->select('*')
            ->first();

        return compact('device');
    }

    public function deviceUpdate(Request $request)
    {
        DB::table('device_setting')
        ->update(
            ['enable' => 1,
            'max_temperature' => $request->max_temperature,
            'max_co2' => $request->max_co2,
            'updated_at'=> DB::raw('NOW()')]
        );
        return back();
    }

}
