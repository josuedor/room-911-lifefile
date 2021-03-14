<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Department;
use App\Models\Access;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'identification',
        'password',
        'email',
        'status',
        'roles_id',
        'departments_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $appends = [
        'total_accesses',
        'last_access',
        'last_activity'
    ];

    public function roles() 
    {
        return $this->hasOne(Role::class, 'id', 'roles_id');

    }

    public function deparments() 
    {
        return $this->hasOne(Department::class, 'id', 'departments_id');
    }

    public function accesses_admin()
    {
        return $this->hasMany(Access::class, 'users_admin', 'id')->latest();
    }

    public function accesses_user()
    {
        return $this->hasMany(Access::class, 'users_access', 'id')->where('confirmed', 1)->latest();
    }

    public function isAdmin() {
        return $this->roles()->where('name', 'admin_room_911')->exists();
    }

    public function getTotalAccessesAttribute() {
        return $this->accesses_user()->count();
    }

    public function getLastAccessAttribute() {
        $access = $this->accesses_user()->latest()->first();
        if ($access) {
            return $access->created_at;
        }
        return '';
    }

    public function getLastActivityAttribute() {
        $session = DB::table('sessions')->where('user_id', $this->id)->first();
        if ($session) {
            $activity = new Carbon($session->last_activity);
            return $activity->toTimeString();
        }
        return '';
    }
}
