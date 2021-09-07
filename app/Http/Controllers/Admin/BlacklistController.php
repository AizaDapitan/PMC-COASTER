<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\Blacklist;
use App\Services\RoleRightService;

class BlacklistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        RoleRightService $roleRightService
    ) {
        // $this->middleware('auth');
        $this->roleRightService = $roleRightService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Blacklist");
        if (!$rolesPermissions['view']) 
        {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];
        $pagination = $rolesPermissions['pagination'];

        $blacklists = Blacklist::paginate(15);
        return view('admin.blacklist', compact(
            'blacklists',
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

        $blacklist = new Blacklist([
            'employee_id' => $request->get('id'),
        ]);

        $blacklist->save();

        return redirect()->back();
    }

    public function destroy($id)
    {

        $blacklist = Blacklist::findOrFail($id);
        $blacklist->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $blacklists = Blacklist::leftjoin('employees', 'employees.empId', '=', 'blacklists.employee_id')
            ->where('employees.name', 'LIKE', '%' . $q . '%')
            ->orWhere('employees.empId', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');

        $blacklists->appends(array(
            'q' => $request->get('q')
        ));

        $rolesPermissions = $this->roleRightService->hasPermissions("Blacklist");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];
        $pagination = $rolesPermissions['pagination'];

        return view('admin.blacklist', compact(
            'blacklists',
            'create',
            'edit',
            'search',
            'print',
            'pagination'
        ));
    }
}
