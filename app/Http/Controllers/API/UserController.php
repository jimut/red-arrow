<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\AppointmentService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->middleware('auth:api');

        $this->appointmentService = $appointmentService;
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $user->hospital;
        $user->donor;
        
        return $user->toArray();
    }

    public function donation(Request $request)
    {
        if ($request->user()->hospital) abort(403);

        $completed = $this->appointmentService->getCompletedAppointments($request->user()->donor);

        return response()->json([
            'completed' => $completed
        ]);
    }
}
