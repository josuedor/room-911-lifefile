<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['users_admin', 'users_access', 'confirmed'];

    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;

    public function users_admin_all()
    {
        return $this->hasOne(User::class, 'id', 'users_admin');
    }

    public function users_access_all()
    {
        return $this->hasOne(User::class, 'id', 'users_access');
    }

}
