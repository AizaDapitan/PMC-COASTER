<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApplicationService;
use App\Role;
use App\Services\RoleRightService;
use Notification;
use App\Application;
use App\Notifications\EmailNofication;
use App\Notifications\ShutdownNotification;
use App\User;
use App\Events\ScheduleShutdown;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    private $applicationService;
    private $roleRightService;

    public function __construct(
        ApplicationService $applicationService,
        RoleRightService $roleRightService
    ) {
        $this->applicationService = $applicationService;
        $this->roleRightService = $roleRightService;
    }

    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Application Maintenance");

        $view = $rolesPermissions['view'];
        if (!$view) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $pagination = $rolesPermissions['pagination'];

        // $applications = Application::paginate(15);
        $applications = Application::orderBy('scheduled_date','desc')->paginate(15);
        return view('admin.application', compact(
            'applications',
            'create',
            'edit',
            'search',
            'pagination'
        ));
    }

    public function store(Request $request)
    {
        $result = $this->applicationService->create($request);
        return $result;
    }
    public function edit(Request $request)
    {
        return response()->json($this->applicationService->getById($request->id));
    }

    public function update(Request $request)
    {
        return $this->applicationService->update($request);
    }

    public function destroy($id)
    {
        return $this->applicationService->destroy($id);
    }
    public function notifications()
    {
        return Application::orderBy('id', 'desc')->first()->toArray();
    }
    public function systemDown()
    {
        $sessions = glob(storage_path("framework/sessions/*"));
        foreach($sessions as $file){
          if(is_file($file))
            unlink($file);
        }
        Artisan::call('down');
        return redirect()->back()->with('down', 'System is in Maintenance Mode!');
    }
    public function systemUp()
    {
        Artisan::call('up');
        return redirect()->back()->with('success', 'System back Online!');
    }
  
    public function create_indexing()
    {
        $application = DB::update('EXEC runScheduledIndexing');

        if ($application) {
            return redirect()->back()->with('success', 'Reindex Application Database Successful!');
        } else {
            return redirect()->back()->with('errors', 'Reindex Application Database Failed.');
        }
    }
    public function search(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Application Maintenance");
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $pagination = $rolesPermissions['pagination'];

        $q = $request->get('q');

        $applications = Application::where('reason', 'LIKE', '%' . $q . '%')
            ->orWhere('scheduled_date', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');

        $applications->appends(array(
            'q' => $request->get('q')
        ));

        $rolesPermissions = $this->roleRightService->hasPermissions("Application Maintenance");

        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $pagination = $rolesPermissions['pagination'];

        return view('admin.application', compact(
            'applications',
            'create',
            'edit',
            'search',
            'pagination'
        ));
    }
}
