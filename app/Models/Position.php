<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable=['name', 'dept_id', 'created_by'];

    /**
     * Get the Position that owns the Position
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
