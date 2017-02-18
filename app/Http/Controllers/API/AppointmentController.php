<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Appointment;
use App\Events\AppointmentCreated;
use App\Services\AppointmentService;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->middleware('auth:api');

        $this->appointmentService = $appointmentService;
    }

    public function store(Request $request)
    {
        if ($request->user()->donor) abort(403);

        $appointment = $this->appointmentService->createAppointment($request->user()->hospital->id, $request->donor_id);

        event(new AppointmentCreated($appointment));

        return response()->json([
            'success' => true,
            'appointment' => $appointment
        ]);
    }

    public function sent(Request $request)
    {
        if ($request->user()->donor) abort(403);

        $sent = $this->appointmentService->getVirginAppointments($request->user()->hospital, true);

        return response()->json([
            'sent' => $sent
        ]);
    }

    public function received(Request $request)
    {
        if ($request->user()->hospital) abort(403);

        $received = $this->appointmentService->getVirginAppointments($request->user()->donor, true);

        return response()->json([
            'received' => $received
        ]);
    }

    public function accepted(Request $request)
    {
        $appointee = $request->user()->hospital ?: $request->user()->donor;

        $accepted = $this->appointmentService->getAcceptedAppointments($appointee, true);

        return response()->json([
            'accepted' => $accepted
        ]);
    }

    public function approved(Request $request)
    {
        if ($request->user()->donor) abort(403);

        $approved = $this->appointmentService->getCompletedAppointments($request->user()->hospital, true);

        return response()->json([
            'approved' => $approved
        ]);
    }

    public function accept(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if ($request->user()->hospital) abort(403);

        if ($request->user()->donor->id !== $appointment->donor_id) abort(403);

        $this->appointmentService->acceptAppointment($appointment);

        return redirect()->route('api.appointment.accepted');
    }

    public function reject(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if ($request->user()->hospital) abort(403);

        if ($request->user()->donor->id !== $appointment->donor_id) abort(403);

        $this->appointmentService->rejectAppointment($appointment);

        return redirect()->route('api.appointment.received');
    }

    public function approve(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if ($request->user()->donor) abort(403);

        if ($request->user()->hospital->id !== $appointment->hospital_id) abort(403);

        $this->appointmentService->approveAppointment($appointment);

        return redirect()->route('api.appointment.accepted');
    }
}
