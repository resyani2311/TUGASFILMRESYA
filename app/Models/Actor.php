<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $table = 'perans';

    protected $fillable = [
        'film_id',
        'cast_id',
        'nama',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function cast()
    {
        return $this->belongsTo(Cast::class);
    }
}