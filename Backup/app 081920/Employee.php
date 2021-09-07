<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public function blacklists()
    {
        return $this->hasOne('App\Blacklist','employee_id', 'empId');
    }

    public function priorities()
    {
        return $this->hasOne('App\Priority','employee_id','empId');
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
