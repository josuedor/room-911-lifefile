<?php

namespace App\Exports;

use App\Models\Access;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class AccessExport implements FromView
{
    use Exportable;

    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function view(): View
    {
        $access = Access::with('users_admin_all', 'users_access_all')
        ->where('users_access', $this->user_id)
        ->latest()
        ->get();
        return view('export-access', compact('access'));
    }
}
