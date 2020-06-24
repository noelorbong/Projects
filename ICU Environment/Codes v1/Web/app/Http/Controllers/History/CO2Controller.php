<?php

namespace App\Http\Controllers\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CO2Controller extends Controller
{
            /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pageshistory.co2');
    }

    public function selectedDate($startdate, $endtdate)
    {
        $co2 = DB::table('co2')
            ->select('*')
            ->where('co2.created_at', '>=', $startdate)
            ->where('co2.created_at', '<=', $endtdate)
            ->orderByRaw('id DESC')
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
