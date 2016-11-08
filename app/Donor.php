<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
