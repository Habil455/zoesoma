<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorAssignments extends Model
{
    use HasFactory;
    protected $guarded = [];


    // for relationship
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_by', 'id');
    }
}
