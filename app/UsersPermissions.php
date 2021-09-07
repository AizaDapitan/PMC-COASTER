<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPermissions extends Model
{    
    protected $fillable = [
        'user_id', 
        'permission_id', 
        'module_id',
        'action',
    ];
    
}
