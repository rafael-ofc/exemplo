<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'name',
        'birthdate',
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
