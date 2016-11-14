<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function donor()
    {
        return $this->belongsTo('App\Donor');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
}
