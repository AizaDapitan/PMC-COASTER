<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Booking;
use App\Schedule;
use App\Employee;

class BookingController extends Controller
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
        $monSched = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();
        $monSchedString = new Carbon($monSched->travel_date);
        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        $satSchedString = new Carbon($satSched->travel_date);
        $bookings = Booking::where('sched', $satSched->travel_date)->get();
        $bookingSeats = Booking::where('sched', $satSched->travel_date)->pluck('seatNumber')->toArray();

        $bookingsMonday = Booking::where('sched', $monSched->travel_date)->get();
        $bookingSeatsMonday = Booking::where('sched', $monSched->travel_date)->pluck('seatNumber')->toArray();

        return view('admin.booking', compact('bookings', 'satSchedString', 'monSchedString', 'bookingSeats', 'bookingsMonday', 'bookingSeatsMonday'));
    }


    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->back();
    }

    public function mondayprint()
    {
        $today = Carbon::now()->toFormattedDateString();
        $monSched = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();
        $monSchedString = new Carbon($monSched->travel_date);
        $bookingsMonday = Booking::where('sched', $monSched->travel_date)->get();
        $bookingSeatsMonday = Booking::where('sched', $monSched->travel_date)->pluck('seatNumber')->toArray();
        return view('admin.print.monday', compact('monSchedString', 'bookingsMonday', 'bookingSeatsMonday', 'today'));
    }

    public function satprint()
    {
        $today = Carbon::now()->toFormattedDateString();
        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        $satSchedString = new Carbon($satSched->travel_date);
        $bookings = Booking::where('sched', $satSched->travel_date)->get();
        $bookingSeats = Booking::where('sched', $satSched->travel_date)->pluck('seatNumber')->toArray();
        return view('admin.print.saturday', compact('satSchedString', 'bookings', 'bookingSeats', 'today'));
    }
}
