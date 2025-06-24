<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceType extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function insuranceApplications()
    {
        return $this->hasMany(InsuranceApplication::class, 'insurance_type_id');
    }
}
