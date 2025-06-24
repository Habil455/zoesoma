<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePayment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'insurance_payments';

    public function insurance()
    {
        return $this->belongsTo(InsuranceApplication::class, 'insurance_id');
    }
    public function insuranceApplication()
    {
        return $this->belongsTo(InsuranceApplication::class, 'insurance_application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }
}
