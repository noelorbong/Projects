<?php

namespace App\Http\Controllers\Sensors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CO2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pagessensors.co2');
    }

    public function realTimeCo2()
    {
        $co2 = DB::table('co2')
            ->select('*')
            ->orderByRaw('id DESC')
            ->limit(100)
            ->get();

        return compact('co2');
    }

    public function realTimeCo2Update()
    {
        $co2 = DB::table('co2')
            ->select('*')
            ->orderByRaw('id DESC')
            ->limit(1)
            ->get();

        return compact('co2');
    }
}
