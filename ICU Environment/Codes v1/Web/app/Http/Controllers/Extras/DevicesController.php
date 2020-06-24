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

}
