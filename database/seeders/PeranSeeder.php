<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\Film;
use App\Models\Peran;
use Illuminate\Database\Seeder;

class PeranSeeder extends Seeder
{
    public function run(): void
    {
        mt_srand(2026);
        $castIds = Cast::pluck('id')->all();
        $jenis = ['Tokoh Utama', 'Lawan Main', 'Antagonis', 'Sahabat Tokoh Utama', 'Mentor', 'Ibu', 'Ayah', 'Detektif', 'Pemeran Pendukung', 'Cameo'];
        $nama = ['Raka', 'Laras', 'Bima', 'Sekar', 'Arga', 'Dewi', 'Satria', 'Nadia', 'Wira', 'Kirana', 'Damar', 'Maya', 'Indra', 'Ayu', 'Joko', 'Tari'];

        foreach (Film::pluck('id') as $filmId) {
            // 3-5 pemeran unik per film
            $jumlah = mt_rand(3, 5);
            $dipilih = (array) array_rand(array_flip($castIds), $jumlah);
            shuffle($dipilih);
            $namaFilm = $nama;
            shuffle($namaFilm);   // nama tokoh tidak boleh kembar dalam satu film
            foreach ($dipilih as $idx => $castId) {
                Peran::create([
                    'film_id' => $filmId,
                    'cast_id' => $castId,
                    'actor'   => $namaFilm[$idx].' ('.$jenis[$idx].')',
                ]);
            }
        }
    }
}
