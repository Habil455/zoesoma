<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceApplication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function insuranceType()
    {
        return $this->belongsTo(InsuranceType::class, 'insurance_type');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function customerBeneficiary()
    {
        return $this->belongsTo(CustomerBeneficiary::class, 'customer_beneficiary_id');
    }
    public function identificationType()
    {
        return $this->belongsTo(IdentificationType::class, 'id_type');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
