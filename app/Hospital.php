<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name', 'reg_no', 'address', 'contact_no', 'map_lat', 'map_lng'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
