<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Auth;

class Booking extends Model implements AuditableContract
{
    
    use Auditable;
    protected $guarded = [];
    protected $dates = ['travel_date'];
    protected $auditInclude = [
        'seatNumber', 
        'employee_id', 
        'destination',
        'pword',
        'schedule',
        'isConfirm',
        'sched',
    ];  
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id', 'empId');
    }
}
