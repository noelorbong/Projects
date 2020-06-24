<?php

namespace App\Http\Controllers\History;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HumidityController extends Controller
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
        return view('pageshistory.humidity');
    }

    public function selectedDate($startdate, $endtdate)
    {
        $humidities = DB::table('humidities')
            ->select('*')
            ->where('humidities.created_at', '>=', $startdate)
            ->where('humidities.created_at', '<=', $endtdate)
            ->orderByRaw('id DESC')
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
