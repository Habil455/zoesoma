<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'employees';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function district(){
        return $this->belongsTo(District::class, 'district_id', 'id');
     }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    use HasPermissionsTrait; //Import The Trait

    public function positions()
    {
        return $this->belongsTo(Position::class, 'position');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function customers()
    {
        return $this->hasMany(Customer::class, 'created_by', 'id');
    }
}
