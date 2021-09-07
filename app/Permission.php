<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Permission extends Model implements AuditableContract
{
    use Auditable;
    protected $guarded = [];

    protected $fillable = [
        'module_type', 
        'description', 
        'active',
    ];
    protected $auditInclude = [
        'module_type', 
        'description', 
        'active',
    ];
}
