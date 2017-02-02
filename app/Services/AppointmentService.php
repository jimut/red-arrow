<?php

namespace App\Services;

use App\Appointment;

class AppointmentService
{
    public function createAppointment($hospital_id, $donor_id)
    {
        return Appointment::create([
            'hospital_id' => $hospital_id,
            'donor_id' => $donor_id,
            'status' => Appointment::SENT
        ]);
    }

    public function getVirginAppointments($appointee)
    {
        return $this->getAppointmentByStatus($appointee, Appointment::SENT);
    }

    public function getAcceptedAppointments($appointee)
    {
        return $this->getAppointmentByStatus($appointee, Appointment::ACCEPTED);
    }

    public function getCompletedAppointments($appointee)
    {
        return $this->getAppointmentByStatus($appointee, Appointment::COMPLETED);
    }

    public function acceptAppointment(Appointment $appointment)
    {
        $appointment->status = Appointment::ACCEPTED;
        $appointment->save();
    }

    public function rejectAppointment(Appointment $appointment)
    {
        $appointment->status = Appointment::REJECTED;
        $appointment->save();
    }

    public function approveAppointment(Appointment $appointment)
    {
        $appointment->status = Appointment::COMPLETED;
        $appointment->save();
    }

    private function getAppointmentByStatus($appointee, $status)
    {
        $appointments = $appointee->appointments;
        $picked = [];

        foreach ($appointments as $appointment) {
            if ($appointment->status === $status) {
                $picked[] = $appointment;
            }
        }

        return $picked;
    }
}
