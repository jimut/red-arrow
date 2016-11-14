<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;

use App\Http\Requests;

class AppointmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $appointment = new Appointment;
        $appointment->donor_id = $request->donor_id;
        $appointment->hospital_id = $request->user()->hospital->id;
        $appointment->status = Appointment::SENT;
        $appointment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => 1
            ]);
        }
    }
}
