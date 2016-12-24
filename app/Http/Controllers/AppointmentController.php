<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Events\AppointmentCreated;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->donor) {
            abort(403);
        }

        $appointment = new Appointment;
        $appointment->donor_id = $request->donor_id;
        $appointment->hospital_id = $request->user()->hospital->id;
        $appointment->status = Appointment::SENT;
        $appointment->save();

        event(new AppointmentCreated($appointment));

        if ($request->ajax()) {
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
