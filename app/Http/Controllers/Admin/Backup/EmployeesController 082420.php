<?php

namespace App\Http\Controllers\Admin;

use App\Blacklist;
use Carbon\Carbon;
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
        $employees = Employee::paginate(15);
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

    public function deactivate($id, Request $request)
    {
        $employee = Employee::where('empId' ,$id)->first();

        if( $request->has('deleteBooking') ) {

            $employee->update(['isNotActive' => 1]);
            $employee->bookings()->whereDate('sched', '>=', Carbon::now()->format('Y-m-d'))->delete();

        } else {

            if ($employee->bookings()->whereDate('sched', '>=', Carbon::now()->format('Y-m-d') )->first() ) {

                \Session::put('booking', $employee->empId);

            } else {

                $employee->update(['isNotActive' => 1]);

            }

        }



        return back();
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
