<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,   // role harus ada lebih dulu sebelum user
            GenreSeeder::class,
            CastSeeder::class,
            FilmSeeder::class,
            PeranSeeder::class,
            ProfileSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            KritikSeeder::class,
        ]);
    }
}
