<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Booking;
use App\Schedule;
use App\Employee;
use App\Services\RoleRightService;

class BookingController extends Controller
{

    private $roleRightService;
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

        $rolesPermissions = $this->roleRightService->hasPermissions("Booking");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];
        
        $monSched = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();
        $bookingsMonday = [];
        $bookingSeats = [];
        $monSchedString = '';
        $satSchedString = '';
        $bookingSeatsMonday = [];
        $bookings = [];

        if ($monSched) {
            $monSchedString = new Carbon($monSched->travel_date);
            $bookingsMonday = Booking::where('sched', $monSched->travel_date)->get();
            $bookingSeatsMonday = Booking::where('sched', $monSched->travel_date)->pluck('seatNumber')->toArray();
        }
        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();

        if ($satSched) {
            $satSchedString = new Carbon($satSched->travel_date);
            $bookings = Booking::where('sched', $satSched->travel_date)->get();
            $bookingSeats = Booking::where('sched', $satSched->travel_date)->pluck('seatNumber')->toArray();
        }

        return view('admin.booking', compact(
            'bookings',
            'satSchedString',
            'monSchedString',
            'bookingSeats',
            'bookingsMonday',
            'bookingSeatsMonday',
            'create',
            'edit',
            'search',
            'print'
        ));
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
        $monSchedString = '';
        $bookingsMonday = [];
        $bookingSeatsMonday = [];
        if ($monSched) {
            $monSchedString = new Carbon($monSched->travel_date);
            $bookingsMonday = Booking::where('sched', $monSched->travel_date)->get();
            $bookingSeatsMonday = Booking::where('sched', $monSched->travel_date)->pluck('seatNumber')->toArray();
        }
        return view('admin.print.monday', compact('monSchedString', 'bookingsMonday', 'bookingSeatsMonday', 'today'));
    }

    public function satprint()
    {
        $today = Carbon::now()->toFormattedDateString();
        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        $bookingSeats = [];
        $bookings = [];
        $satSchedString = '';

        if ($satSched) {
            $satSchedString = new Carbon($satSched->travel_date);
            $bookings = Booking::where('sched', $satSched->travel_date)->get();
            $bookingSeats = Booking::where('sched', $satSched->travel_date)->pluck('seatNumber')->toArray();
        }

        return view('admin.print.saturday', compact('satSchedString', 'bookings', 'bookingSeats', 'today'));
    }
}
