<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['role:admin_room_911']);
    }

    public function users(Request $request)
    {   
        $users = User::with('roles', 'deparments', 'accesses_user')->paginate(14);
        $departments = Department::all();
        $roles = Role::all();
        //return compact('users', 'departments', 'roles');
        return view('dashboard', compact('users', 'departments', 'roles'));
    }

    public function userEnabledOrDisable(Request $request)
    {   
        $user_id = $request->user_id;
        if ($user_id) {
            $users = User::find($user_id);
            $users->status = $users->status == 'enabled' ? 'disabled' : 'enabled';
            $users->save();
            return back()->with([
                'ok' => 'User was updated',
            ]);
        }
        return back()->withErrors([
            'error' => 'Wrong data sended',
        ]);
    }

    public function removeUser(Request $request)
    {
        $user_id = $request->user_id;
        if ($user_id) {
            $users = User::find($user_id)->delete();
            return back()->with([
                'ok' => 'User was removed',
            ]);
        }
        return back()->withErrors([
            'error' => 'Wrong data sended',
        ]);
    }

    public function saveUser(Request $request)
    {
        
        $user_id = $request->user_id;
        $firstname = $request->firstname;
        $middlename = $request->middlename;
        $lastname = $request->lastname;
        $identification = $request->identification;
        $email = $request->email;
        $password = $request->password;
        $status = $request->status;
        $department = $request->department;
        $role = $request->role;

        if ($firstname && $middlename && $lastname && $identification && $email && $password & $status && $department && $role) {
            $users = User::updateOrCreate(
                [ 'id' => $user_id ],
                [
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'lastname' => $lastname,
                    'identification' => $identification,
                    'email' => $email,
                    'password' => $this->getPasswordUser($user_id) == $password ? $password : bcrypt($password),
                    'status' => $status,
                    'departments_id' => $department,
                    'roles_id' => $role
                ]
            );
            return back()->with([
                'ok' => 'User was created or updated',
            ]);
        }
        return back()->withErrors([
            'error' => 'Wrong data sended, all inputs are required',
        ]);
    }

    private function getPasswordUser($user_id)
    {
        $user = User::find($user_id);
        //Log::info(print_r($user, true));
        if ($user && $user->password) {
            return $user->password;
        }
        return null;
    }

    public function searchUsers(Request $request)
    {
        $search = $request->search;
        $deparment = $request->departments;

        $date_init = $request->date_init;
        $date_end = $request->date_end;
        $search_by = $request->search_by;

        $users = '';
        if ($search && $deparment && $date_init && $date_end) {
            $users = User::with('roles', 'deparments', 'accesses_user')
                ->where(function($query) use ($search_by, $search) {
                    switch ($search_by) {
                        case 'identification':
                            $query->where('identification', 'LIKE', "%$search%");
                            break;

                        case 'lastname':
                            $query->where('lastname', 'LIKE', "%$search%");
                            break;

                        case 'middlename':
                            $query->where('middlename', 'LIKE', "%$search%");
                            break;

                        case 'firstname':
                            $query->where('firstname', 'LIKE', "%$search%");
                            break;

                        default:
                            # code...
                            break;
                    }
                })->where('departments_id', $deparment)
                ->whereDate('created_at','>=', $date_init) // Que esten en el rango de fechas
                ->whereDate('created_at','<=', $date_end)
                ->paginate(14);
        }elseif($search && $date_init && $date_end){
            $users = User::with('roles', 'deparments', 'accesses_user')
                ->where(function($query) use ($search_by, $search) {
                    switch ($search_by) {
                        case 'identification':
                            $query->where('identification', 'LIKE', "%$search%");
                            break;

                        case 'lastname':
                            $query->where('lastname', 'LIKE', "%$search%");
                            break;

                        case 'middlename':
                            $query->where('middlename', 'LIKE', "%$search%");
                            break;

                        case 'firstname':
                            $query->where('firstname', 'LIKE', "%$search%");
                            break;

                        default:
                            # code...
                            break;
                    }
                })
                ->whereDate('created_at','>=', $date_init)
                ->whereDate('created_at','<=', $date_end)
                ->paginate(14);
        }elseif ($search && $deparment) {
            $users = User::with('roles', 'deparments', 'accesses_user')
                ->where(function($query) use ($search_by, $search) {
                    switch ($search_by) {
                        case 'identification':
                            $query->where('identification', 'LIKE', "%$search%");
                            break;

                        case 'lastname':
                            $query->where('lastname', 'LIKE', "%$search%");
                            break;

                        case 'middlename':
                            $query->where('middlename', 'LIKE', "%$search%");
                            break;

                        case 'firstname':
                            $query->where('firstname', 'LIKE', "%$search%");
                            break;

                        default:
                            # code...
                            break;
                    }
                })->where('departments_id', $deparment)
                ->paginate(14);
        }else{
            $users = User::with('roles', 'deparments', 'accesses_user')
                ->where(function($query) use ($search_by, $search) {
                    switch ($search_by) {
                        case 'identification':
                            $query->where('identification', 'LIKE', "%$search%");
                            break;

                        case 'lastname':
                            $query->where('lastname', 'LIKE', "%$search%");
                            break;

                        case 'middlename':
                            $query->where('middlename', 'LIKE', "%$search%");
                            break;

                        case 'firstname':
                            $query->where('firstname', 'LIKE', "%$search%");
                            break;

                        default:
                            # code...
                            break;
                    }
                })->paginate(14);
        }
        
        $departments = Department::all();
        $roles = Role::all();
        return view('dashboard', compact('users', 'departments', 'roles'));
    }

    public function import(Request $request) 
    {
        $file = $request->file('file');
        if($file) {
            $path = Storage::disk('public')->put('files/users', $file);
            Excel::import(new UsersImport, storage_path('app/public/'.$path));
            return redirect('/dashboard')->with([
                'ok' => 'Users are imported',
            ]);
        }
        return redirect('/dashboard')->withErrors([
            'error' => 'File is empty',
        ]);
    }
}
