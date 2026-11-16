<?php

namespace Database\Seeders;

use App\Models\Cast;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CastSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $faker->seed(2026);

        $bio = [
            'Aktor kelahiran %s yang dikenal lewat peran-peran karakter yang kuat.',
            'Aktris berbakat asal %s, memulai karier dari panggung teater kampus.',
            'Pemeran serba bisa dari %s, sering memerankan tokoh pendukung yang mencuri perhatian.',
            'Mantan model asal %s yang beralih ke dunia akting dan meraih beberapa nominasi penghargaan.',
            'Pemeran senior dari %s dengan pengalaman lebih dari dua dekade di layar lebar.',
        ];

        for ($i = 1; $i <= 60; $i++) {
            Cast::create([
                'name' => $i % 2
                ? $faker->firstName('male').' '.$faker->lastName()
                : $faker->firstName('female').' '.$faker->lastName(),
                'age'  => $faker->numberBetween(19, 68),
                'bio'  => sprintf($bio[$i % count($bio)], $faker->city),
            ]);
        }
    }
}
