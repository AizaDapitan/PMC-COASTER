<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UserRepository implements UserRepositoryInterface
{
    protected $user;
    protected $action;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function create($fields)
    {
        return $this->user->create($fields);
    }

    public function update($fields, $id)
    {
        return $this->user->find($id)->update($fields);
    }

    public function destroy($id)
    {
        return $this->user->find($id)->delete();
    }

    public function getById($id)
    {
        return $this->user->find($id);
    }

    public function GetRoleName($role_id)
    {
        try {
            $roles = DB::table('roles')
                ->select(
                    'roles.name  as role_name'
                )
                ->where('roles.id', '=', $role_id)
                ->first();
            return $roles;
        } catch (QueryException $e) {
            return null;
        }
    }
}
