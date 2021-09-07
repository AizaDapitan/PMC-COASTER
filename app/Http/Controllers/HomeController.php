<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Booking;
use App\Schedule;
use App\Employee;
use App\Feedback;

class HomeController extends Controller
{
    public function index()
    {
        $seatArray = [1, 6, 11, 21, 26, 31, 36, 12, 17, 22, 32, 37, 3, 8, 13, 18, 23, 28, 33, 38, 4, 9, 14, 19, 24, 29, 34, 39, 5, 10, 15, 20, 25, 30, 35, 40];
        
        if( Carbon::SUNDAY ) {
            $nextMonday     = Carbon::now()->startOfWeek()->addWeek(2); 
            $nextSaturday   = Carbon::now()->endOfWeek()->addWeek()->subDay(1);
        } else {
            $nextMonday     = Carbon::now()->startOfWeek()->addWeek(1); 
            $nextSaturday   = Carbon::now()->endOfWeek()->subDay(1);            
        }

        $closedDays = [7,1,2,3];

        $monSched = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();

        if( $monSched ) {
            $monSchedString = new Carbon($monSched->travel_date);            

            if( in_array(Carbon::now()->dayOfWeek, $closedDays) ) {

                if( $monSchedString->lt(Carbon::now() ) ) {
                
                    $monSched->update(['isClosed' => 1]);

                    $this->createSchedule($nextMonday->format('Y-m-d'), "Monday");
                    $monSchedString = $nextMonday;
                
                }

            }

        } else {

            $this->createSchedule($nextMonday->format('Y-m-d'), "Monday");
            $monSchedString = $nextMonday;

        }

        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        if( $satSched ) {
            $satSchedString = new Carbon($satSched->travel_date);

            if( in_array(Carbon::now()->dayOfWeek, $closedDays) ) {

                if( $satSchedString->lt(Carbon::now()->format('Y-m-d')) ) {
                    $satSched->update(['isClosed' => 1]);

                    $this->createSchedule($nextSaturday->format('Y-m-d'), "Saturday");
                    $satSchedString = $nextSaturday;
                }

            }
        } else {

            $this->createSchedule($nextSaturday->format('Y-m-d'), "Saturday");
            $satSchedString = $nextSaturday;

        }


        $bookings = Booking::all();

        return view('home', compact('bookings', 'satSchedString', 'monSchedString', 'seatArray'));
    }

    public function createSchedule($travel_date, $travel_day) {

        Schedule::create([
            'travel_date'   => $travel_date ,
            'travel_day'    => $travel_day ,
            'isClosed'      => 0
        ]);

    }

    public function destroy(Request $request, $id)
    {

        $booking = Booking::where('pword', $id)->where('sched', $request->travelDayFormat)->first();
        $booking->delete();

        return redirect('/');
    }

    public function feedback(Request $request)
    {
        $request->validate([
            'empid' => 'required',
            'message' => 'required',
        ]);

        $employee = Employee::where('empId', 'PMC-' . $request->empid)->first();
        if (!$employee) {
            $request->session()->flash('errorMesssage', '<strong>Feedback!</strong> Your ID number does not exist on our record. Please contact GSD office @ local 3113');
            return redirect()->back();
        }
        $feedback = new Feedback([
            'employee_id' => $employee->id,
            'message' => $request->message,
        ]);

        $feedback->save();
        $request->session()->flash('successMesssage', '<strong>Success!</strong> Your feedback was sent. ');

        return redirect('/');
    }

    public function store(Request $request)
    {
        $request->validate([
            'empid' => 'required',
            'message' => 'required',
        ]);

        //$employee = Employee::where('empId', 'PMC-' . $request->empid)->first();

        $employee = Employee::where('empId', $request->empid)->first();
        if (!$employee) {
            $request->session()->flash('errorMesssage', '<strong>Feedback!</strong> Your ID number does not exist on our record. Please contact GSD office @ local 3113');
            return redirect()->back();
        }
        $feedback = new Feedback([
            'employee_id' => $employee->id,
            'message' => $request->message,
        ]);

        $feedback->save();
        $request->session()->flash('successMesssage', '<strong>Success!</strong> Your feedback was sent. ');
        
        return redirect('/');
    }
}
