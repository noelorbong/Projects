<?php

namespace App\Http\Controllers\Sensors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TemperatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pagessensors.temperature');
    }

    public function realTimeTemp()
    {
        $temperatures = DB::table('temperatures')
            ->select('*')
            ->orderByRaw('id DESC')
            ->limit(100)
            ->get();

        return compact('temperatures');
    }

    public function realTimeTempUpdate()
    {
        $temperatures = DB::table('temperatures')
            ->select('*')
            ->orderByRaw('id DESC')
            ->limit(1)
            ->get();

        return compact('temperatures');
    }

}
