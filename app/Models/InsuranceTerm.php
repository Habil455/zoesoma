<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceTerm extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type_id');
    }
    public function insuranceApplication()
    {
        return $this->hasMany(InsuranceApplication::class, 'insurance_term');
    }
}
