<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isUserRegistered = false;
        if (Auth::user()->hospital || Auth::user()->donor) {
            $isUserRegistered = true;
        }

        $isUserHospital = false;
        if (Auth::user()->hospital) {
            $isUserHospital = true;
        }

        return view('home', [
            'isUserRegistered' => $isUserRegistered,
            'isUserHospital' => $isUserHospital,
        ]);
    }
}
