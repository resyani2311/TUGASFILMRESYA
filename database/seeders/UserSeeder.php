<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /** 10 user biasa, password semuanya: 12345678 */
    public function run(): void
    {
        $names = [
            ['Budi Santoso', 'budi'], ['Siti Rahmawati', 'siti'], ['Andi Pratama', 'andi'], ['Dewi Lestari', 'dewi'],
            ['Rizky Ramadhan', 'rizky'], ['Putri Maharani', 'putri'], ['Fajar Nugroho', 'fajar'], ['Ayu Wulandari', 'ayu'],
            ['Dimas Saputra', 'dimas'], ['Nanda Kusuma', 'nanda'],
        ];
        $roleId = Role::where('name', 'user')->value('id');
        $profiles = Profile::orderBy('id')->take(10)->pluck('id');

        foreach ($names as $i => [$name, $slug]) {
            User::create([
                'name'              => $name,
                'email'             => "{$slug}@example.com",
                'email_verified_at' => now(),
                'password'          => '12345678',
                'role_id'           => $roleId,
                'profile_id'        => $profiles[$i],
            ]);
        }
    }
}
