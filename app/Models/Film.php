<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'ringkasan',
        'tahun',
        'poster',
        'backdrop',
        'trailer',
        'genre_id',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function kritiks(): HasMany
    {
        return $this->hasMany(Kritik::class);
    }

    public function perans(): HasMany
    {
        return $this->hasMany(Actor::class);
    }

    /** Tambahkan jumlah komentar (kritiks_count) dan rata-rata point (rating_avg). */
    public function scopeWithRatings(Builder $query): Builder
    {
        return $query->withCount('kritiks')->withAvg('kritiks as rating_avg', 'point');
    }

    public function getAverageRatingAttribute(): float
    {
        return round((float) $this->kritiks->avg('point'), 1);
    }

    public function getPosterUrlAttribute(): string
    {
        return $this->poster ? asset('storage/'.$this->poster) : asset('images/no-poster.svg');
    }

    public function getBackdropUrlAttribute(): ?string
    {
        return $this->backdrop ? asset('storage/'.$this->backdrop) : null;
    }

    public function getTrailerUrlAttribute(): ?string
    {
        return $this->trailer ? asset('storage/'.$this->trailer) : null;
    }
}
