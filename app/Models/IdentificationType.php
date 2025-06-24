<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentificationType extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'id_type');
    }
    public function customerBeneficiaries()
    {
        return $this->hasMany(CustomerBeneficiary::class, 'id_type');
    }
    public function insuranceTypes()
    {
        return $this->hasMany(InsuranceType::class, 'id_type');
    }
}
