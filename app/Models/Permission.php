<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
   //
   //use SoftDeletes;

    protected $fillable = [
        'slug', 'sys_module_id'
    ];

    protected $with = ['modules'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    public function modules()
    {
        return $this->belongsTo(SystemModule::class, 'sys_module_id');
    }
}
