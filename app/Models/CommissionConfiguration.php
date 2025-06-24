<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionConfiguration extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'commission_configurations';

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
