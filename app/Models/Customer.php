<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customers';
    public function identificationType()
    {
        return $this->belongsTo(IdentificationType::class, 'id_type');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function overseers()
    {
        return $this->belongsTo(Overseer::class, 'id', 'customer_id');
    }
}
