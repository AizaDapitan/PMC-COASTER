<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolesPermissions extends Model
{    
    protected $fillable = [
        'role_id', 
        'permission_id', 
        'module_id',
        'action',
    ];

}
