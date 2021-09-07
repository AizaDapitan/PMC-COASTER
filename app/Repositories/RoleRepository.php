<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Role;

class RoleRepository implements RoleRepositoryInterface
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        return $this->role->all();
    }

    public function create($fields)
    {
        return $this->role->create($fields);
    }

    public function update($fields, $id)
    {
        return $this->role->find($id)->update($fields);
    }

    public function destroy($id)
    {
        return $this->role->find($id)->delete();
    }

    public function getById($id)
    {
        return $this->role->find($id);
    }

   
}