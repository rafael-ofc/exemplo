<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'allowed',
        'title',
        'cover',
        'days',
        'start_time',
        'end_time',
    ];

    public function disabled()
    {
        return $this->hasMany(AreaDisabled::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
