<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['name'  => 'Action',],
            ['name'  => 'Biography',],
            ['name'  => 'Crime',],
            ['name'  => 'Family',],
            ['name'  => 'Horror',],
            ['name'  => 'Romance',],
            ['name'  => 'Sports',],
            ['name'  => 'War',],
            ['name'  => 'Adventure',],
            ['name'  => 'Comedy',],
            ['name'  => 'Documentary',],
            ['name'  => 'Fantasy',],
            ['name'  => 'Thriller',],
            ['name'  => 'Animation',],
            ['name'  => 'Costume',],
            ['name'  => 'Drama',],
            ['name'  => 'History',],
            ['name'  => 'Musical',],
            ['name'  => 'Psychological',],
        ];

        Genre::insert($genres);
    }
}
