<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
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

    public function getAvatarAttribute($attr)
    {
        if (substr($attr, 0, 8) === 'https://' || substr($attr, 0, 7) === 'http://') {
            return $attr;
        }

        return url('imagecache/avatar/' . $attr);
    }
}
