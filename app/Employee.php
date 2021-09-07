<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Employee extends Model implements AuditableContract
{
    
    use Auditable;
    protected $guarded = [];

    protected $auditInclude = [
        'empId', 
        'name', 
        'dept',
        'location', 
        'address1', 
        'address2',
        'expireDate', 
        'cid', 
        'isNotActive',
    ];

    public function blacklists()
    {
        return $this->hasOne('App\Blacklist','employee_id', 'empId');
    }

    public function priorities()
    {
        return $this->hasOne('App\Priority','employee_id', 'empId', 'id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking','employee_id', 'empId');
    }

    public function feedbacks()
    {
        return $this->hasMany('App\Feedback');
    }
}
