<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function blacklists()
    {
        return $this->hasOne('App\Blacklist');
    }

    public function priorities()
    {
        return $this->hasOne('App\Priority');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }
}
