<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccessExport;

class AccessController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['role:admin_room_911']);
    }

    public function access(Request $request)
    {
        return view('access');
    }

    public function createAccess(Request $request)
    {
        $credentials = $request->identification;
        if ($credentials) {
            $user = User::where('identification', $credentials)->first();
            if ($user) {
                if ($user->status === 'enabled') {
                    $access = new Access;
                    $access->users_admin = Auth::user()->id;
                    $access->users_access = $user->id;
                    $access->confirmed = 1;
                    $access->save();
                    return back()->with([
                        'ok' => 'Access granted',
                    ]);
                }else{
                    $access = new Access;
                    $access->users_admin = Auth::user()->id;
                    $access->users_access = $user->id;
                    $access->confirmed = 0;
                    $access->save();
                    return back()->withErrors([
                        'error' => 'The Employed is not enabled',
                    ]);
                }
            }else{
                $access = new Access;
                $access->users_admin = Auth::user()->id;
                $access->confirmed = 0;
                $access->save();
                return back()->withErrors([
                    'error' => 'The Employed is not registered',
                ]);
            }

        }
        return back()->withErrors([
            'error' => 'The identification is requited',
        ]);
    }

    public function accessUsers(Request $request, $id)
    {
        $access = Access::with('users_admin_all', 'users_access_all')->where('users_access', $id)->latest()->paginate(14);
        //return compact('access');
        return view('access-list', compact('access'));
    }

    public function searchAccessUsers(Request $request, $id)
    {
        $date_init = $request->date_init;
        $date_end = $request->date_end;
        if ($id && $date_init && $date_end) {
            $access = Access::with('users_admin_all', 'users_access_all')->where('users_access', $id)
                ->whereDate('created_at','>=', $date_init)
                ->whereDate('created_at','<=', $date_end)    
                ->latest()
                ->paginate(14);
            //return compact('access');
            return view('access-list', compact('access'));
        }

        return back()->withErrors([
            'error' => 'Dates are required',
        ]);
    }

    public function export(Request $request, $id) 
    {
        return (new AccessExport($id))->download('access-user-room-911.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
    
    
}
