<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Priority;
use App\Services\RoleRightService;
use App\Services\AuditService;

class PriorityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        RoleRightService $roleRightService,
        AuditService $auditService
    ) {
        // $this->middleware('auth');
        $this->roleRightService = $roleRightService;
        $this->auditService = $auditService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Priority");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];
        $print = $rolesPermissions['print'];
        $pagination = $rolesPermissions['pagination'];
        $priorities = Priority::paginate(15);
        return view('admin.priority', compact(
            'priorities',
            'create',
            'edit',
            'search',
            'print',
            'pagination'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $priority = new Priority([
            'employee_id' => $request->get('id'),
        ]);

        $priority->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $priority = Priority::findOrFail($id);
        $priority->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $priorities = Priority::leftjoin('employees', 'employees.empId', '=', 'priorities.employee_id')
            ->where('employees.name', 'LIKE', '%' . $q . '%')
            ->orWhere('employees.empId', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');

        $priorities->appends(array(
            'q' => $request->get('q')
        ));
        
        // $saveLogs = $this->auditService->create($request,"Search ". $q . " in Priority","Search");
        $rolesPermissions = $this->roleRightService->hasPermissions("Priority");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];
        $print = $rolesPermissions['print'];
        $pagination = $rolesPermissions['pagination'];

        return view('admin.priority', compact(
            'priorities',
            'create',
            'edit',
            'search',
            'print',
            'pagination'
        ));
    }
}
