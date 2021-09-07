<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Schedule;
use App\Employee;
use App\Booking;
use Illuminate\Support\Str;

class SaturdayController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seatArray = [1, 6, 11, 16, 21, 26, 31, 36, 2, 7, 12, 17, 22, 27, 32, 37, 3, 8, 13, 18, 23, 28, 33, 38, 4, 9, 14, 19, 24, 29, 34, 39, 5, 10, 15, 20, 25, 30, 35, 40];
        $booking_days = array('Tuesday','Wednesday', 'Thursday', 'Friday', 'Saturday');

        $monSched = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();
        $monSchedString = new Carbon($monSched->travel_date);
        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        $satSchedString = new Carbon($satSched->travel_date);
        $displayMain = $this->displayBooking($booking_days);
        $satFormat = $satSchedString->format('Y-m-d');

        $employee = Booking::where('sched', $satFormat)->get();
        $bookingCount = $employee->count();

        $reservedSeats = $this->getReservedSeats($employee);
        return view('saturday', compact('satSched', 'satSchedString', 'monSchedString', 'seatArray', 'displayMain', 'reservedSeats', 'bookingCount'));
    }

    public function getReservedSeats($seats)
    {
        $reservedSeats = [];
        foreach ($seats as $seat) {
            array_push($reservedSeats, $seat->seatNumber);
        }

        return $reservedSeats;
    }

    public function displayBooking($booking_days)
    {

        $today = Carbon::now();
        $dayToday = $today->isoFormat('dddd');
        // $dayToday = 'Wednesday';
        $tym = $today->format('H');

        if (in_array($dayToday, $booking_days)) {
            if ($dayToday == 'Tuesday' && $tym < 7) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function store(Request $request)
    {

        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        $bookings = Booking::where('sched', $satSched->travel_date)->get();
        $employee = Employee::where('empId', $request->employee)->first();
        $booking_days = array('Tuesday','Wednesday', 'Thursday', 'Friday', 'Saturday');
        $bookEmployee = Booking::where('sched', $satSched->travel_date)->where('employee_id', $employee->empId)->first();
        // $booking_days = array('Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $todayDay = Carbon::now()->isoFormat('dddd');
        // $todayDay = 'Wednesday';

        if ($bookEmployee) {
            $request->session()->flash('errorMesssage', '<strong>Booking failed!</strong> Your ID number already has a booked seat.');
            return redirect()->back();
        }

        if ($employee->blacklists) {
            $request->session()->flash('errorMesssage', '<strong>Booking failed!</strong> Your account has been blacklisted, Please contact the admin at GSD office local 3113.');
            return redirect()->back();
        }

        if ($employee->isNotActive) {
            $request->session()->flash('errorMesssage', '<strong>Booking failed!</strong> Your ID number does not exist on our record. Please contact GSD office @ local 3113');
            return redirect()->back();
        }

        foreach ($bookings as $booking) {
            if ($booking->seatNumber == $request->sit) {
                $request->session()->flash('errorMesssage', '<strong>Booking failed!</strong> The seat is already taken.');
                return redirect()->back();
            }
        }

        if (!in_array($todayDay, $booking_days)) {
            $request->session()->flash('errorMesssage', '<strong>Booking failed!</strong> You are not yet allowed to book today. Booking schedule for CHANCE PASSENGERS are every FRIDAY and SATURDAY');
            return  redirect()->back();
        }

        if ($todayDay == 'Wednesday' || $todayDay == 'Thursday') {
            if (!$employee->priorities) {
                $request->session()->flash('errorMesssage', '<strong>Booking failed!</strong> You are not yet allowed to book today. Booking schedule for CHANCE PASSENGERS are every FRIDAY and SATURDAY');
                return  redirect()->back();
            }
        }

        $newBooking = new Booking([
            'seatNumber' => $request->sit,
            'employee_id' => $employee->empId,
            'destination' => $request->destination,
            'pword' => Str::random(4),
            'sched' => $satSched->travel_date
        ]);
        $newBooking->save();

        if ($employee->address1 == null) {
            $employee->address1 = $request->address1;
            $employee->address2 = $request->address2 == 'Others' ?  $request->address2m : $request->address2;
            $employee->save();
        }

        $request->session()->flash('successMesssage', '<strong>Success!</strong> Your booking was confirmed. Your password is <strong style="font-size:20px;color:blue;"">' . $newBooking->pword . '</strong> use this to cancel or verify your booking info.');
        return  redirect()->back();
    }
}
