<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AppointmentService;

class UserController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->middleware('auth');

        $this->appointmentService = $appointmentService;
    }

    public function donation(Request $request)
    {
        if ($request->user()->hospital) abort(403);

        $completed = $this->appointmentService->getCompletedAppointments($request->user()->donor);

        return view('donor.donation', [
            'completed' => $completed
        ]);
    }
}
