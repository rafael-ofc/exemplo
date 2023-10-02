<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'title',
        'color',
        'plate',
    ];

    protected $hidden = [
        'unit_id',
        'created_at',
        'updated_at',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
