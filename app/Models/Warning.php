<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'title',
        'status',
        'photos',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
