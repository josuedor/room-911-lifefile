<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
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

    protected $dates = ['deleted_at'];

    public function roles() 
    {
        return $this->belongsToMany('App\Models\Role', 'roles', 'id', 'roles_id');
    }

    public function Department() 
    {
        return $this->belongsToMany('App\Models\Department', 'deparments', 'id', 'departments_id');
    }

    public function isAdmin() {
        return $this->roles()->where('name', 'admin_room_911')->exists();
    }
}
