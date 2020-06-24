<?php

namespace App\Http\Controllers\History;

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
        return view('pageshistory.temperature');
    }

    public function selectedDate($startdate, $endtdate)
    {
        $temperatures = DB::table('temperatures')
            ->select('*')
            ->where('temperatures.created_at', '>=', $startdate)
            ->where('temperatures.created_at', '<=', $endtdate)
            ->orderByRaw('id DESC')
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
