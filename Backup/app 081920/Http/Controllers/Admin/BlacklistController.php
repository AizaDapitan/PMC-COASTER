<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\Blacklist;

class BlacklistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blacklists = Blacklist::paginate(15);
        return view('admin.blacklist', compact('blacklists'));
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

        $blacklists = Blacklist::join('employees', 'blacklists.employee_id', '=', 'employees.id')
            ->where('employees.name', 'LIKE', '%' . $q . '%')
            ->orWhere('employees.empId', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(2)->setPath('');

        $blacklists->appends(array(
            'q' => $request->get('q')
        ));

        return view('admin.blacklist', compact('blacklists'));
    }
}
