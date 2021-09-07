<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserRightService;
use App\Services\UserService;
use App\Services\PermissionService;
use App\Services\RoleRightService;

class UserRightController extends Controller
{
    private $userrightService;
    private $userService;
    private $permissionService;

    public function __construct(
        UserRightService $userrightService,
        UserService $userService,
        PermissionService $permissionService,
        RoleRightService $roleRightService
    ) {
        $this->userrightService = $userrightService;
        $this->userService = $userService;
        $this->permissionService = $permissionService;
        $this->roleRightService = $roleRightService;
    }
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("User Rights");

        if (!$rolesPermissions['view']) {
            abort(401);
        }
        $users =  $this->userService->all()->where('active', '1')->where('username','<>', '')->where('role','<>', 'ADMIN')->sortBy('name');
        $permissions = $this->permissionService->all()->where('active', '1')->sortBy('description');
        $modules = $this->permissionService->getModule()->sortBy('description');

       
        $create = $rolesPermissions['create'];

        return view('admin.useraccessrights', compact(
            'users',
            'permissions',
            'modules',
            'create'
        ));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $users_permissions = $this->userrightService->getById($request->userid);
            return $users_permissions;
        }
        
        return $this->userrightService->create($request);
    }
}
