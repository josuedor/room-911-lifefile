<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code'
    ];

    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany('App\Models\User', 'roles_id', 'id');
    }
}
