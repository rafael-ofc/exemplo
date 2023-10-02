<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaDisabled extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'day',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
