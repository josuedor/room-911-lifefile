<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $dates = ['deleted_at'];

    public function users_admin() 
    {
        return $this->belongsToMany('App\Models\User', 'users', 'id', 'users_admin');
    }

    public function users_access() 
    {
        return $this->belongsToMany('App\Models\User', 'users', 'id', 'users_access');
    }

}
