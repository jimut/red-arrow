<?php

namespace App\Http\Controllers;

use Auth;
use App\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $appointmentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AppointmentService $appointmentService)
    {
        $this->middleware('auth');

        $this->appointmentService = $appointmentService;
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

        if ($user->hospital) {
            return view('hospital.home', [
                'hospital' => $user->hospital,
                'count' => $this->appointmentService->getCount($user->hospital)
            ]);
        }

        if ($user->donor) {
            return view('donor.home', [
                'donor' => $user->donor,
                'count' => $this->appointmentService->getCount($user->donor)
            ]);
        }

        return view('home');
    }
}
