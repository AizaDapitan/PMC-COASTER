<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
