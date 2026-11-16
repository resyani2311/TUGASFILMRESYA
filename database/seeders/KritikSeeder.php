<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Kritik;
use App\Models\User;
use Illuminate\Database\Seeder;

class KritikSeeder extends Seeder
{
    public function run(): void
    {
        mt_srand(2026);

        // komentar [teks, rating]
        $komentar = [
            ['Ceritanya seru banget, dari awal sampai akhir nggak bikin bosan!', 5],
            ['Akting para pemainnya natural, apalagi tokoh utamanya. Recommended!', 5],
            ['Sinematografinya indah, setiap adegan terasa seperti lukisan.', 5],
            ['Plot twist di akhir benar-benar tidak terduga. Salut untuk sutradaranya.', 5],
            ['Film yang menghibur untuk ditonton bersama keluarga di akhir pekan.', 4],
            ['Musik latarnya pas dan memperkuat suasana. Layak ditonton ulang.', 4],
            ['Bagus, walaupun beberapa bagian di tengah terasa agak lambat.', 4],
            ['Alurnya menarik dan dialognya cerdas. Hanya endingnya kurang greget.', 4],
            ['Efek visualnya keren untuk ukuran film seperti ini.', 4],
            ['Lumayan menghibur, cocok buat mengisi waktu luang.', 3],
            ['Biasa saja, tapi masih enak diikuti sampai selesai.', 3],
            ['Ide ceritanya bagus, sayang eksekusinya kurang matang.', 3],
            ['Ada bagian yang bikin terharu, ada juga yang terasa klise.', 3],
            ['Karakternya kurang digali, padahal potensinya besar.', 2],
            ['Terlalu banyak adegan yang bisa ditebak, jadi kurang kejutan.', 2],
            ['Pacing-nya berantakan, bagian akhir terasa terburu-buru.', 2],
            ['Kecewa, ekspektasi saya jauh lebih tinggi dari hasilnya.', 1],
            ['Ceritanya membingungkan dan banyak lubang plot.', 1],
        ];
        // bobot: lebih banyak komentar positif
        $bobot = [4, 4, 3, 3, 4, 3, 3, 3, 2, 3, 3, 2, 2, 1, 1, 1, 1, 1];
        $pool = [];
        foreach ($bobot as $i => $w) {
            for ($k = 0; $k < $w; $k++) { $pool[] = $i; }
        }

        $userIds = User::whereHas('role', fn ($q) => $q->where('name', 'user'))->pluck('id')->all();
        $filmIds = Film::pluck('id')->all();

        for ($i = 0; $i < 700; $i++) {
            [$teks, $rating] = $komentar[$pool[mt_rand(0, count($pool) - 1)]];
            Kritik::create([
                'comment' => $teks,
                'rating'  => $rating,
                'film_id' => $filmIds[mt_rand(0, count($filmIds) - 1)],
                'user_id' => $userIds[mt_rand(0, count($userIds) - 1)],
            ]);
        }
    }
}
