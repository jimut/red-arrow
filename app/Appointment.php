<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    const SENT = 'SENT';
    const ACCEPTED = 'ACCEPTED';
    const COMPLETED = 'COMPLETED';
    const TIMED_OUT = 'TIMED_OUT';
    const BETRAYED = 'BETRAYED';
        
    public function donor()
    {
        return $this->belongsTo('App\Donor');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
}
