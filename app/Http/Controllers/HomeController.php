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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isUserRegistered = false;
        $isUserHospital = false;
        $isUserDonor = false;

        if (Auth::user()->hospital) {
            $isUserRegistered = true;
            $isUserHospital = true;
        }

        if (Auth::user()->donor) {
            $isUserRegistered = true;
            $isUserDonor = true;
        }

        if ($request->ajax()) {
            $user = Auth::user();

            $userInformation = 'User is not registered';
            if ($isUserHospital) {
                $userInformation = $user->hospital->toArray();
            } else if ($isUserDonor) {
                $userInformation = $user->donor->toArray();
            }

            return response()->json([
                'isUserRegistered' => $isUserRegistered,
                'isUserHospital' => $isUserHospital,
                'isUserDonor' => $isUserDonor,
                'userInformation' => $userInformation
            ]);
        }

        return view('home', [
            'isUserRegistered' => $isUserRegistered,
            'isUserHospital' => $isUserHospital,
            'isUserDonor' => $isUserDonor
        ]);
    }
}
