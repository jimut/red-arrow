<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $rules = [
        'review' => 'required'
    ];

    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'show'
        ]]);
    }

    public function show(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        return view('review.show', [
            'appointment' => $appointment
        ]);
    }

    public function create(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if ($request->user()->donor) abort(403);

        if ($request->user()->hospital->id !== $appointment->hospital_id) abort(403);

        return view('review.create', [
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

        return redirect()->route('appointment.review.show', $appointment);
    }
}
