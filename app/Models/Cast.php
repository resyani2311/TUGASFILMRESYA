<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'umur',
        'bio',
    ];

    public function perans()
    {
        return $this->hasMany(Actor::class);
    }
}