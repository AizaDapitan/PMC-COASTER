<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Priority extends Model implements AuditableContract
{
    use Auditable;
    protected $guarded = [];
    protected $auditInclude = [
        'employee_id', 
    ];
    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','empId');
    }
}
