<?php

namespace App\Http\Controllers\API;

use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    protected $rules = [
        'review' => 'required'
    ];

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'show'
        ]]);
    }

    public function show(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        return response()->json([
            'appointment' => $appointment
        ]);
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $appointment = Appointment::find($id);

        $appointment->update([
            'donor_review' => $request->review
        ]);

        return redirect()->route('api.appointment.review.show', $appointment);
    }
}
