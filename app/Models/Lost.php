<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lost extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'body',
        'where',
        'path',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
