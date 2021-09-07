<?php

namespace App\Http\Controllers\Admin;

use App\Blacklist;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Booking;
use App\Services\RoleService;
use App\Services\RoleRightService;

class RoleController extends Controller
{

    private $roleService;
    public function __construct(
        RoleService $roleService,
        RoleRightService $roleRightService
    ) {

        $this->roleService = $roleService;
        $this->roleRightService = $roleRightService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = auth()->user()->role;
        $rolesPermissions = $this->roleRightService->hasPermissions("Roles Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $pagination = $rolesPermissions['pagination'];

        $roles = Role::paginate(15);
        return view('admin.roles', compact(
            'roles',
            'create',
            'edit',
            'search',
            'pagination'
        ));
    }

    public function store(Request $request)
    {

        $request->validate([
            'role' => 'required',
            'description' => 'required',
        ]);

        $status = $request->has('active');

        $role = new Role([
            'name' => $request->get('role'),
            'description' => $request->get('description'),
            'active' => $status
        ]);

        $role->save();

        return redirect('admin/roles');
    }

    public function search(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Roles Maintenance");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $pagination = $rolesPermissions['pagination'];

        $q = $request->get('q');

        $roles = Role::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('id', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');

        $roles->appends(array(
            'q' => $request->get('q')
        ));

        $rolesPermissions = $this->roleRightService->hasPermissions("Roles Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $pagination = $rolesPermissions['pagination'];

        return view('admin.roles', compact(
            'roles',
            'create',
            'edit',
            'search',
            'pagination'
        ));
        // ));

        // return view('admin.roles', compact('roles'));

    }

    public function edit(Request $request)
    {
        return response()->json($this->roleService->getById($request->id));
    }

    public function update(Request $request)
    {
        return $this->roleService->update($request);
    }
}
