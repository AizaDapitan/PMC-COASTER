<?php

namespace App\Services;
use App\Permission;
use App\Repositories\Interfaces\RoleRepositoryInterface;
class RoleService
{
    protected $repository;

    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $roles = $this->repository->all();

        $data = collect();
        foreach ($roles as $role) {
            $data->push([
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
                'active' => $role->active,
            ]);
        }

        return $data;
    }

    public function create($fields)
    {
        $status = $fields->has('active');
        $data = [
            'id' => $fields->id,
            'name' => strtoupper($fields->role),
            'description' => $fields->description,
            'active' => $status,
        ];

        $role = $this->repository->create($data);

        if ($role) {
            return redirect()->back()->with('success', 'Role has been added successfully!');
        }
        else {
            return redirect()->back()->with('errors', 'Adding Role failed.');
        }
    }

    public function update($fields)
    {
        // $assigneduser = User::where([['role_id',$fields->id],['active','1']])->first();
        // $haspermission = RolesPermissions::where('role_id',$fields->id)->first();

        $status = $fields->has('active');

        // if($assigneduser && $status == false )
        // {

        //     return redirect()->back()->with('failed', 'Role has assigned user!'); 
        // }
        // if($haspermission && $status == false)
        // {

        //     return redirect()->back()->with('failed', 'Role has assigned permission!'); 
        // }
        $data = [
            'name' => strtoupper($fields->role),
            'description' => $fields->description,
            'active' => $status,
        ];

        $role = $this->repository->update($data, $fields->id);

        if ($role) {
            return redirect()->back()->with('success', 'Role has been updated successfull!');
        }
        else {
            return redirect()->back()->with('errors', 'Updating Role failed.');
        }
    }

    public function getById($id)
    {
        $role = $this->repository->getById($id);

        $data = [
            'id' => $role->id,
            'name' => $role->name,
            'description' => $role->description,
            'active' => $role->active,
        ];

        return $data;
    }
    public function destroy($request, $id)
    {
        // $assigneduser = User::where([['role_id',$id],['active','1']])->first();
        // $haspermission = RolesPermissions::where('role_id',$id)->first();


        // if($assigneduser)
        // {

        //     return redirect()->back()->with('failed', 'Role has assigned user!'); 
        // }
        // if($haspermission)
        // {

        //     return redirect()->back()->with('failed', 'Role has assigned permission!'); 
        // }
        $role = $this->repository->destroy($id);

        if ($role) {
            return redirect()->back()->with('success', 'Role has been removed successfully!');
        }
        else {
            return redirect()->back()->with('failed', 'Failed removing role!');
        }
    }

    // public function hasPermission($id)
    // {
    //     $permission = Role::
    // }

}