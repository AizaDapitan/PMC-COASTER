<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Role;
use App\Services\RoleRightService;
use Notification;
use App\User;
use App\Notifications\EmailNofication;

class UserController extends Controller
{
    private $userService;

    public function __construct(
        UserService $userService,
        RoleRightService $roleRightService
    ) {
        $this->userService = $userService;
        $this->roleRightService = $roleRightService;
    }

    public function index()
    {
        $rolesPermissions = $this->roleRightService->hasPermissions("Users Maintenance");

        $view = $rolesPermissions['view'];
        if (!$view) {
            abort(401);
        }
        $roles = Role::where('active', '1')->get();        
        $users = User::paginate(15);
        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];
        $search = $rolesPermissions['search'];
        $pagination = $rolesPermissions['pagination'];

        return view('admin.users', compact(
            'roles',
            'users',
            'create',
            'edit',
            'search',
            'pagination'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'username' => 'required',   
            'role_id' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        if ($user) 
        {
            $request->session()->flash('errorMesssage', '<strong>Username!</strong> already existings.');                        
            return redirect()->back();
        }
        else
        {
            $userEmail = User::where('email', $request->email)->first();
            if ($userEmail) 
            {
                $request->session()->flash('errorMesssage', '<strong>Email!</strong> already existings.');                        
                return redirect()->back();
            }            
            else
            {
                $result = $this->userService->create($request);
                $user = User::orderBy('id','desc')->first();
                if ($request->session()->get('success') == "User has been added successfully!") 
                {
                    $user->notify(new EmailNofication($user));
                }
                return $result;
            }
        }

    }
    public function search(Request $request)
    {
        $q = $request->get('q');
        $users = User::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('id', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');
        $users->appends(array(
            'q' => $request->get('q')
        ));
        $roles = Role::where('active', '1')->get();

        return view('admin.users', compact('users', 'roles'));
    }
    public function edit(Request $request)
    {
        return response()->json($this->userService->getById($request->id));
    }
    public function update(Request $request)    
    {
        return $this->userService->update($request);
    }  
}
