<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'path',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
