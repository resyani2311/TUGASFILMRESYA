<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable(['name', 'username', 'email', 'password', 'last_login_at', 'role_id', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function kritiks(): HasMany
    {
        return $this->hasMany(Kritik::class);
    }

    /** Nama role ("admin" / "user"). Akun tanpa role dianggap user biasa. */
    public function roleName(): string
    {
        return $this->role?->name ?? Role::USER;
    }

    public function isAdmin(): bool
    {
        return $this->roleName() === Role::ADMIN;
    }

    public function isRegularUser(): bool
    {
        return ! $this->isAdmin();
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::get(fn () => $this->avatar ? asset('storage/'.$this->avatar) : null);
    }

    protected function initial(): Attribute
    {
        return Attribute::get(fn () => Str::upper(Str::substr($this->name ?: '?', 0, 1)));
    }

    /** Hapus berkas foto profile dari storage (jika ada). */
    public function deleteAvatarFile(): void
    {
        if ($this->avatar) {
            Storage::disk('public')->delete($this->avatar);
        }
    }
}
