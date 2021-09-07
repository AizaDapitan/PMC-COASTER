<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function all()
    {
        return $this->permission->all();
    }

    public function create($fields)
    {
        return $this->permission->create($fields);
    }

    public function update($fields, $id)
    {
        return $this->permission->find($id)->update($fields);
    }

    public function destroy($id)
    {
        return $this->permission->find($id)->delete();
    }

    public function getById($id)
    {
        return $this->permission->find($id);
    }

    public function getModule(){

        return $this->permission->getModule();
    }

   
}