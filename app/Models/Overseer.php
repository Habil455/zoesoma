<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overseer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'overseer_id');
    }
    public function id_types()
    {
        return $this->belongsTo(IdentificationType::class, 'id_type');
    }
    public function customers(){

        return $this->hasOne(Customer::class, 'customer_id');
    }
}
