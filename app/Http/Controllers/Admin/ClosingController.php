<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Schedule;
use App\Services\RoleRightService;
use App\Services\AuditService;

class ClosingController extends Controller
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

        $rolesPermissions = $this->roleRightService->hasPermissions("Closing");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $print = $rolesPermissions['print'];

        $scheds = Schedule::orderBy('created_at', 'desc')->get();
        $monSched = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();
        $satSched = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        $dayToday = Carbon::now()->isoFormat('dddd');

        return view('admin.closing', compact(
            'scheds',
            'monSched',
            'satSched',
            'dayToday',
            'create',
            'edit',
            'search',
            'print'
        ));
    }
    public function cutoff(Request $request )
    {
        $lastOpenMonday = Schedule::where('isClosed', 0)->where('travel_day', 'Monday')->first();
        $lastMonday = new Carbon($lastOpenMonday->travel_date);
        $lastOpenSaturday = Schedule::where('isClosed', 0)->where('travel_day', 'Saturday')->first();
        $lastSaturday = new Carbon($lastOpenSaturday->travel_date);

        $monday = $lastMonday->addDays(7);
        $saturday = $lastSaturday->addDays(7);

        $todayDay = Carbon::now()->isoFormat('dddd');
        if ($todayDay == 'Monday') {

            $openSched = Schedule::where('isClosed', 0)->get();
            foreach ($openSched as $open) {
                $open->isClosed = 1;
                $open->save();
            }

            $openSatSched = new Schedule([
                'travel_date' => $saturday->format('Y-m-d'),
                'travel_day' => $saturday->isoFormat('dddd'),
            ]);
            $openSatSched->save();

            $openMonSched = new Schedule([
                'travel_date' => $monday->format('Y-m-d'),
                'travel_day' => $monday->isoFormat('dddd'),
            ]);

            $openMonSched->save();
            
        $saveLogs = $this->auditService->create($request,"Closing Schedule","close");
            return redirect('admin/closing');
        }
    }
}
