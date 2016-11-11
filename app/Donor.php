<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name', 'dob', 'address', 'contact_no', 'blood_type', 'health_issues', 'map_lat', 'map_lng'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
