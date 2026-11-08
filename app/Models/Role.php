<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    public const ADMIN = 'admin';

    public const USER = 'user';

    protected $fillable = ['name'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /** ID role "user" (dibuat otomatis jika belum ada), dipakai saat register. */
    public static function userId(): int
    {
        return static::firstOrCreate(['name' => self::USER])->id;
    }
}
