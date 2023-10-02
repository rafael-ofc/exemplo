<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billets()
    {
        return $this->hasMany(Billet::class);
    }

    public function peoples()
    {
        return $this->hasMany(People::class);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function warnings()
    {
        return $this->hasMany(Warning::class);
    }
}
