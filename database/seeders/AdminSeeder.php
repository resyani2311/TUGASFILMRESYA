<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /** Akun administrator: admin@example.com / 12345678 */
    public function run(): void
    {
        $profile = Profile::create([
            'umur'   => 30,
            'alamat' => 'Jl. Teknologi No. 1, Jakarta',
            'bio'    => 'Administrator OneMovies',
        ]);

        User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@example.com',
            'email_verified_at' => now(),
            'password'          => '12345678',
            'role_id'           => Role::where('name', 'admin')->value('id'),
            'profile_id'        => $profile->id,
        ]);
    }
}
