<?php

namespace App\Http\Controllers\Admin;

use App\Blacklist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\Booking;

class EmployeesController extends Controller
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
        $employees = Employee::where('isNotActive', 0)->paginate(15);
        return view('admin.employees', compact('employees'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'expireDate' => 'required',
        ]);

        if ($emp = Employee::latest()->first()) {
            $empId = $emp->cid + 1;
        } else {
            $empId = 1;
        }

        $employee = new Employee([
            'name' => $request->get('name'),
            'expireDate' => $request->get('expireDate'),
            'empId' => $this->gen_empid($empId),
            'cid' => $empId
        ]);

        $employee->save();

        return redirect('admin/employees');
    }

    public function gen_empid($n)
    {
        $r = strlen($n);
        $e = 4 - $r;
        $z = "";
        for ($x = 1; $x <= $e; $x++) {
            $z .= "0";
        }
        $refcode = $z . $n;
        return "PMC-C" . $refcode;
    }

    public function deactivate($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->isNotActive = 1;
        $employee->save();
        if ($employee->bookings) {
            $empBooking = Booking::findOrFail($employee->id);
            $empBooking->delete();
        }
        return redirect('admin/employees');
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $employees = Employee::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('empId', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(2)->setPath('');

        $employees->appends(array(
            'q' => $request->get('q')
        ));

        return view('admin.employees', compact('employees'));
    }
}
