<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wall extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
