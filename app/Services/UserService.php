<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $users = $this->repository->all();

        $data = collect();
        foreach ($users as $user) {
            $data->push([
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'locked' => $user->locked,
                'locked_at' => $user->locked_at,
                'approver' => $user->approver,
                'role' => $user->role,
                'active' => $user->active,
                'role_id' => $user->role_id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
            ]);
        }

        return $data;
    }

    public function create($fields)
    {
        $roles = $this->repository->GetRoleName($fields->role_id);

        $data = [
            'username' => strtoupper($fields->username),
            'role_id' => $fields->role_id,
            'role' => $roles->role_name,
            'firstname' => $fields->firstname,
            'lastname' => $fields->lastname,
            'email' => $fields->email,
            'active' => 1,
            'locked' => 0,
            'name' => $fields->firstname . ' ' . $fields->lastname,
            'password' => bcrypt("password"),
        ];

        $user = $this->repository->create($data);

        if ($user) {
            return redirect()->back()->with('success', 'User has been added successfully!');
        } else {
            return redirect()->back()->with('errors', 'Adding user failed.');
        }
    }

    public function update($fields)
    {
        $status = false;
        $locked = false;

        if ($fields->active) {
            $status = true;
        }
        if ($fields->locked) {
            $locked = true;
        }
        $roles = $this->repository->GetRoleName($fields->role_id);
        $reset = $fields->reset;

        if ($reset == true) {
            $data = [
                'username' => strtoupper($fields->username),
                'role_id' => $fields->role_id,
                'role' => $roles->role_name,
                'firstname' => $fields->firstname,
                'lastname' => $fields->lastname,
                'email' => $fields->email,
                'name' => $fields->firstname . ' ' . $fields->lastname,
                'password' => bcrypt("password"),
                'active' => $status,
                'locked' => $locked,
            ];
        }

        if ($reset == false) {
            $data = [
                'username' => strtoupper($fields->username),
                'role_id' => $fields->role_id,
                'role' => $roles->role_name,
                'firstname' => $fields->firstname,
                'lastname' => $fields->lastname,
                'email' => $fields->email,
                'name' => $fields->firstname . ' ' . $fields->lastname,
                'active' => $status,
                'locked' => $locked,
            ];
        }
        $user = $this->repository->update($data, $fields->id);

        if ($user) {
            return redirect()->back()->with('success', 'User has been updated successfull!');
        } else {
            return redirect()->back()->with('errors', 'Updating user failed.');
        }
    }

    public function getById($id)
    {
        $user = $this->repository->getById($id);

        $data = [
            'id' => $user->id,
            'role' => $user->role,
            'username' => $user->username,
            'role_id' => $user->role_id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'active' => $user->active,
            'locked'  => $user->locked,
        ];

        return $data;
    }

    public function lock($fields, $id)
    {
        $data = [
            'locked' => $fields->status,
            'locked_at' => now(),
        ];

        $user = $this->repository->update($data, $id);

        if ($user) {
            return redirect()->back()->with('success', 'User lock has been updated successfully!');
        } else {
            return redirect()->back()->with('success', 'User lock update failed!');
        }
    }

    public function changeStatus($fields, $id)
    {
        $data = [
            'active' => $fields->status,
        ];

        $user = $this->repository->update($data, $id);

        if ($user) {
            return redirect()->back()->with('success', 'User status has been updated successfully!');
        } else {
            return redirect()->back()->with('success', 'User status update failed!');
        }
    }

    public function destroy($id)
    {
        $user = $this->repository->destroy($id);

        if ($user) {
            return redirect()->back()->with('success', 'User has been removed successfully!');
        } else {
            return redirect()->back()->with('success', 'Failed removing user!');
        }
    }
}
