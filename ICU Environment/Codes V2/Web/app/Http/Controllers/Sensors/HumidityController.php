<?php

namespace App\Http\Controllers\Sensors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HumidityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pagessensors.humidity');
    }

    public function realTimeHumi()
    {
        $humidities = DB::table('humidities')
            ->select('*')
            ->orderByRaw('id DESC')
            ->limit(100)
            ->get();

        return compact('humidities');
    }

    public function realTimeHumiUpdate()
    {
        $humidities = DB::table('humidities')
            ->select('*')
            ->orderByRaw('id DESC')
            ->limit(1)
            ->get();

        return compact('humidities');
    }

}
