<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionPayment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'commission_payments';

    public function insurancePayments()
    {
        return $this->belongsTo(InsurancePayment::class, 'insurance_payment_id');
    }
    public function commissionConfiguration()
    {
        return $this->belongsTo(CommissionConfiguration::class, 'configuration_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
