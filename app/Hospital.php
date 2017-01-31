<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = [
        'avatar'
    ];
    
    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'avatar', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }
}
