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
        $user = Auth::user();

        $isUserRegistered = false;
        $isUserHospital = false;
        $isUserDonor = false;
        $notificationCount = 0;

        if ($user->hospital) {
            $isUserRegistered = true;
            $isUserHospital = true;
        }

        if ($user->donor) {
            $isUserRegistered = true;
            $isUserDonor = true;

            $notificationCount = $user->donor->appointments->count();
        }

        if ($request->ajax()) {
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
            'isUserDonor' => $isUserDonor,
            'notificationCount' => $notificationCount,
        ]);
    }
}
