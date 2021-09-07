<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Priority;

class PriorityController extends Controller
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
        $priorities = Priority::paginate(15);
        return view('admin.priority', compact('priorities'));
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

        $priorities = Priority::join('employees', 'priorities.employee_id', '=', 'employees.id')
            ->where('employees.name', 'LIKE', '%' . $q . '%')
            ->orWhere('employees.empId', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(2)->setPath('');

        $priorities->appends(array(
            'q' => $request->get('q')
        ));

        return view('admin.priority', compact('priorities'));
    }
}
