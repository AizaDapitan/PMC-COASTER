<?php

namespace App\Services;

use App\Permission;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService
{
    protected $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        $permissions = $this->repository->all();

        $data = collect();
        foreach ($permissions as $permission) {
            $data->push([
                'id' => $permission->id,
                'module_type' => $permission->module_type,
                'description' => $permission->description,
                'active' => $permission->active,
            ]);
        }

        return $data;
    }

    public function create($fields)
    {
        $status = $fields->has('active');
        $data = [
            'id' => $fields->id,
            'module_type' => $fields->module_type,
            'description' => $fields->description,
            'active' => $status,
        ];

        $permission = $this->repository->create($data);

        if ($permission) {
            return redirect()->back()->with('success', 'Permission has been added successfully!');
        }
        else {
            return redirect()->back()->with('errors', 'Adding Permission failed.');
        }
    }

    public function update($fields)
    {
        $status = $fields->has('active');

        $data = [
            'module_type' => $fields->module_type,
            'description' => $fields->description,
            'active' => $status,
        ];

        $permission = $this->repository->update($data, $fields->id);

        if ($permission) {
            return redirect()->back()->with('success', 'Permission has been updated successfull!');
        }
        else {
            return redirect()->back()->with('errors', 'Updating Permission failed.');
        }
    }

    public function getById($id)
    {
        $permission = $this->repository->getById($id);

        $data = [
            'id' => $permission->id,
            'module_type' => $permission->module_type,
            'description' => $permission->description,
            'active' => $permission->active,
        ];

        return $data;
    }
    public function destroy($request, $id)
    {

        // $assigneduser  = $request->assigneduser;
        // $assignedroles = $request->assignedroles;
        // if ($assigneduser) {

        //     return redirect()->back()->with('failed', 'Permission has assigned user!');
        // }
        // if ($assignedroles) {

        //     return redirect()->back()->with('failed', 'Permission has assigned roles!');
        // }
        
        $permission = $this->repository->destroy($id);

        if ($permission) {
            return redirect()->back()->with('success', 'Permission has been removed successfully!');
        }
        else {
            return redirect()->back()->with('failed', 'Failed removing Permission!');
        }
    }
    
    public function getModule()
    {

        $modules = DB::table('modules')->get();
        // dd($module);
        $data = collect();
        foreach ($modules as $module) {
            $data->push([
                'id' => $module->id,
                'description' => $module->description,
            ]);
        }

        return $data;
    }

}