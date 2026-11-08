<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Kritik;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Mengisi data awal FilmKu (role, akun uji, genre, film, cast, peran, komentar).
 * Aman dijalankan berulang kali: memakai updateOrCreate sehingga tidak membuat data ganda.
 *
 * Jalankan:  php artisan migrate --seed   (atau)   php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = $this->seedRoles();
        $users = $this->seedUsers($roles);
        $genres = $this->seedGenres();
        $films = $this->seedFilms($genres);
        $casts = $this->seedCasts();
        $this->seedPerans($films, $casts);
        $this->seedKritiks($films, $users);
    }

    /** @return array<string, int> */
    private function seedRoles(): array
    {
        return [
            Role::ADMIN => Role::firstOrCreate(['name' => Role::ADMIN])->id,
            Role::USER => Role::firstOrCreate(['name' => Role::USER])->id,
        ];
    }

    /**
     * Password khusus lingkungan lokal: admin -> admin12345, user -> user12345.
     *
     * @param  array<string, int>  $roles
     * @return array<string, User>
     */
    private function seedUsers(array $roles): array
    {
        $rows = [
            ['admin', 'Administrator', 'admin@filmku.test', Role::ADMIN, 'admin12345'],
            ['user', 'Budi Santoso', 'user@filmku.test', Role::USER, 'user12345'],
            ['sitirahma', 'Siti Rahma', 'siti@filmku.test', Role::USER, 'user12345'],
            ['andipratama', 'Andi Pratama', 'andi@filmku.test', Role::USER, 'user12345'],
            ['dewil', 'Dewi Lestari', 'dewi@filmku.test', Role::USER, 'user12345'],
            ['rizkym', 'Rizky Maulana', 'rizky@filmku.test', Role::USER, 'user12345'],
        ];

        $users = [];
        foreach ($rows as [$username, $name, $email, $role, $password]) {
            $users[$username] = User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'username' => $username, 'password' => $password, 'role_id' => $roles[$role]],
            );
        }

        return $users;
    }

    /** @return array<string, Genre> */
    private function seedGenres(): array
    {
        $genres = [];
        foreach (['Action', 'Sci-Fi', 'Drama', 'Thriller', 'Petualangan'] as $nama) {
            $genres[$nama] = Genre::firstOrCreate(['nama' => $nama]);
        }

        return $genres;
    }

    /**
     * @param  array<string, Genre>  $genres
     * @return array<string, Film>
     */
    private function seedFilms(array $genres): array
    {
        $rows = [
            ['Inception', 2010, 'Sci-Fi', 'Dom Cobb adalah pencuri ulung yang mencuri rahasia dari alam bawah sadar saat targetnya bermimpi. Ia ditawari kesempatan menebus masa lalunya dengan tugas yang nyaris mustahil: menanamkan sebuah ide ke dalam pikiran seseorang.'],
            ['Interstellar', 2014, 'Sci-Fi', 'Saat Bumi tak lagi bisa dihuni, sekelompok penjelajah melintasi lubang cacing demi mencari planet baru untuk umat manusia. Cooper harus memilih antara keluarganya dan masa depan seluruh peradaban.'],
            ['The Dark Knight', 2008, 'Action', 'Batman, Jim Gordon, dan Harvey Dent berusaha membersihkan Gotham dari kejahatan terorganisir. Namun muncul penjahat misterius bernama Joker yang menebar kekacauan dan menguji batas moral sang kesatria kegelapan.'],
            ['John Wick', 2014, 'Action', 'Mantan pembunuh bayaran John Wick keluar dari masa pensiunnya untuk memburu orang-orang yang mencuri mobil dan membunuh anjing pemberian mendiang istrinya.'],
            ['Dune', 2021, 'Petualangan', 'Paul Atreides, pemuda berbakat, harus melakukan perjalanan ke planet gurun paling berbahaya di alam semesta demi memastikan masa depan keluarga dan rakyatnya, ketika kekuatan jahat berebut sumber daya paling berharga: rempah Spice.'],
            ['Oppenheimer', 2023, 'Drama', 'Kisah fisikawan J. Robert Oppenheimer yang memimpin Proyek Manhattan untuk menciptakan bom atom, beserta beban moral dan konsekuensi politik yang menghantuinya setelahnya.'],
            ['Parasite', 2019, 'Thriller', 'Keluarga Ki-taek yang hidup serba kekurangan perlahan menyusup ke kehidupan keluarga kaya Park, hingga sebuah rahasia tersembunyi membuat segalanya berubah menjadi tak terkendali.'],
            ['The Matrix', 1999, 'Sci-Fi', 'Seorang programmer komputer, Neo, mengetahui bahwa dunia yang ia kenal hanyalah simulasi buatan mesin. Ia bergabung dengan pemberontak untuk melawan para pengendali dunia maya tersebut.'],
        ];

        $films = [];
        foreach ($rows as [$judul, $tahun, $genre, $ringkasan]) {
            $slug = Str::slug($judul);

            $films[$judul] = Film::updateOrCreate(
                ['judul' => $judul, 'tahun' => $tahun],
                [
                    'ringkasan' => $ringkasan,
                    'genre_id' => $genres[$genre]->id,
                    'poster' => $this->copyAsset('posters', $slug),
                    'backdrop' => $this->copyAsset('backdrops', $slug),
                ],
            );
        }

        return $films;
    }

    /** Salin gambar contoh dari database/seeders/assets ke storage/app/public agar bisa tampil di web. */
    private function copyAsset(string $folder, string $slug): ?string
    {
        $source = database_path("seeders/assets/{$folder}/{$slug}.jpg");
        $target = "{$folder}/seed-{$slug}.jpg";

        if (! File::exists($source)) {
            return Storage::disk('public')->exists($target) ? $target : null;
        }

        if (! Storage::disk('public')->exists($target)) {
            Storage::disk('public')->put($target, File::get($source));
        }

        return $target;
    }

    /** @return array<string, Cast> */
    private function seedCasts(): array
    {
        $rows = [
            ['Leonardo DiCaprio', 51, 'Aktor dan produser Amerika, pemenang Academy Award untuk Aktor Terbaik lewat The Revenant. Dikenal lewat Titanic, Inception, dan The Wolf of Wall Street.'],
            ['Joseph Gordon-Levitt', 45, 'Aktor Amerika yang tampil di 500 Days of Summer, Looper, dan Inception. Memulai karier sejak kecil di televisi.'],
            ['Elliot Page', 39, 'Aktor Kanada yang dinominasikan Oscar lewat Juno, dan dikenal pula lewat Inception serta serial The Umbrella Academy.'],
            ['Tom Hardy', 49, 'Aktor Inggris yang dikenal lewat Mad Max: Fury Road, Venom, Peaky Blinders, dan The Dark Knight Rises.'],
            ['Matthew McConaughey', 57, 'Aktor Amerika pemenang Academy Award untuk Aktor Terbaik lewat Dallas Buyers Club. Dikenal pula lewat Interstellar dan True Detective.'],
            ['Anne Hathaway', 43, 'Aktris Amerika pemenang Academy Award untuk Aktris Pendukung Terbaik lewat Les Misérables. Juga tampil di The Devil Wears Prada.'],
            ['Jessica Chastain', 49, 'Aktris Amerika pemenang Academy Award untuk Aktris Terbaik lewat The Eyes of Tammy Faye. Tampil di Zero Dark Thirty dan Interstellar.'],
            ['Christian Bale', 52, 'Aktor Inggris pemenang Academy Award lewat The Fighter, dikenal sebagai Batman dalam trilogi The Dark Knight.'],
            ['Aaron Eckhart', 58, 'Aktor Amerika yang memerankan Harvey Dent dalam The Dark Knight, dan tampil di Thank You for Smoking.'],
            ['Keanu Reeves', 62, 'Aktor Kanada yang terkenal lewat seri The Matrix dan John Wick, serta Speed dan Bill & Ted.'],
            ['Timothée Chalamet', 30, 'Aktor Amerika yang dikenal lewat Call Me by Your Name, Little Women, Dune, dan Wonka.'],
            ['Zendaya', 30, 'Aktris dan penyanyi Amerika pemenang Emmy lewat serial Euphoria, juga tampil di Dune dan seri Spider-Man.'],
            ['Cillian Murphy', 50, 'Aktor Irlandia pemenang Academy Award lewat Oppenheimer, dikenal pula lewat Peaky Blinders dan 28 Days Later.'],
            ['Robert Downey Jr.', 61, 'Aktor Amerika yang dikenal sebagai Iron Man di Marvel Cinematic Universe dan pemenang Oscar lewat Oppenheimer.'],
            ['Emily Blunt', 43, 'Aktris Inggris yang tampil di The Devil Wears Prada, A Quiet Place, dan Oppenheimer.'],
            ['Song Kang-ho', 59, 'Aktor Korea Selatan yang sering bekerja sama dengan sutradara Bong Joon-ho, dikenal lewat Memories of Murder dan Parasite.'],
            ['Carrie-Anne Moss', 59, 'Aktris Kanada yang memerankan Trinity dalam seri The Matrix.'],
            ['Laurence Fishburne', 65, 'Aktor Amerika yang memerankan Morpheus dalam seri The Matrix.'],
        ];

        $casts = [];
        foreach ($rows as [$nama, $umur, $bio]) {
            $casts[$nama] = Cast::updateOrCreate(['nama' => $nama], ['umur' => $umur, 'bio' => $bio]);
        }

        return $casts;
    }

    /**
     * @param  array<string, Film>  $films
     * @param  array<string, Cast>  $casts
     */
    private function seedPerans(array $films, array $casts): void
    {
        $rows = [
            ['Inception', 'Leonardo DiCaprio', 'Dom Cobb'],
            ['Inception', 'Joseph Gordon-Levitt', 'Arthur'],
            ['Inception', 'Elliot Page', 'Ariadne'],
            ['Inception', 'Tom Hardy', 'Eames'],
            ['Interstellar', 'Matthew McConaughey', 'Joseph Cooper'],
            ['Interstellar', 'Anne Hathaway', 'Amelia Brand'],
            ['Interstellar', 'Jessica Chastain', 'Murph Cooper'],
            ['The Dark Knight', 'Christian Bale', 'Bruce Wayne / Batman'],
            ['The Dark Knight', 'Aaron Eckhart', 'Harvey Dent'],
            ['John Wick', 'Keanu Reeves', 'John Wick'],
            ['Dune', 'Timothée Chalamet', 'Paul Atreides'],
            ['Dune', 'Zendaya', 'Chani'],
            ['Oppenheimer', 'Cillian Murphy', 'J. Robert Oppenheimer'],
            ['Oppenheimer', 'Robert Downey Jr.', 'Lewis Strauss'],
            ['Oppenheimer', 'Emily Blunt', 'Kitty Oppenheimer'],
            ['Parasite', 'Song Kang-ho', 'Kim Ki-taek'],
            ['The Matrix', 'Keanu Reeves', 'Neo'],
            ['The Matrix', 'Carrie-Anne Moss', 'Trinity'],
            ['The Matrix', 'Laurence Fishburne', 'Morpheus'],
        ];

        foreach ($rows as [$film, $cast, $peran]) {
            Actor::firstOrCreate([
                'film_id' => $films[$film]->id,
                'cast_id' => $casts[$cast]->id,
                'nama' => $peran,
            ]);
        }
    }

    /**
     * @param  array<string, Film>  $films
     * @param  array<string, User>  $users
     */
    private function seedKritiks(array $films, array $users): void
    {
        $rows = [
            ['Inception', 'sitirahma', 5, 'Visual dan musiknya luar biasa. Adegan lorong berputar itu juara.'],
            ['Inception', 'andipratama', 4, 'Seru dan rumit, tapi butuh fokus penuh supaya tidak tersesat.'],
            ['Interstellar', 'user', 5, 'Emosional dan megah. Hubungan ayah dan anak membuat saya hampir menangis.'],
            ['Interstellar', 'dewil', 5, 'Sains dan perasaan menyatu dengan sangat baik. Scoring organnya ikonik.'],
            ['Interstellar', 'rizkym', 4, 'Film luar angkasa terbaik dalam beberapa tahun terakhir, walau bagian akhirnya agak membingungkan.'],
            ['The Dark Knight', 'sitirahma', 5, 'Penampilan Joker tak tertandingi. Film superhero rasa kriminal yang kelam.'],
            ['The Dark Knight', 'andipratama', 5, 'Dilema moralnya dalam dan ceritanya padat dari awal sampai akhir.'],
            ['The Dark Knight', 'dewil', 4, 'Sangat bagus, hanya durasinya terasa panjang di bagian akhir.'],
            ['John Wick', 'rizkym', 4, 'Koreografi aksinya rapi dan stylish. Cocok untuk penggemar aksi murni.'],
            ['John Wick', 'user', 4, 'Cerita sederhana tapi dieksekusi dengan sangat keren.'],
            ['Dune', 'sitirahma', 4, 'Sinematografi gurunnya memukau, terutama jika ditonton di layar besar.'],
            ['Dune', 'dewil', 5, 'Dunia yang dibangun sangat detail. Tidak sabar melihat kelanjutannya.'],
            ['Oppenheimer', 'andipratama', 5, 'Akting Cillian Murphy luar biasa. Tiga jam yang terasa singkat.'],
            ['Oppenheimer', 'user', 4, 'Berat dan intens, tetapi sangat layak ditonton.'],
            ['Parasite', 'rizkym', 5, 'Kritik sosial yang tajam dibalut thriller yang sangat segar. Plot twist-nya gila.'],
            ['Parasite', 'dewil', 5, 'Sinematografi dan naskahnya nyaris sempurna.'],
            ['The Matrix', 'user', 5, 'Klasik fiksi ilmiah yang mengubah cara film aksi dibuat.'],
            ['The Matrix', 'andipratama', 4, 'Konsepnya masih relevan sampai sekarang, efek bullet time-nya legendaris.'],
        ];

        foreach ($rows as [$film, $username, $point, $content]) {
            Kritik::updateOrCreate(
                ['film_id' => $films[$film]->id, 'user_id' => $users[$username]->id],
                ['point' => $point, 'content' => $content],
            );
        }
    }
}
