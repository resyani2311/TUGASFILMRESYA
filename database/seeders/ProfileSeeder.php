<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['umur' => 17, 'alamat' => 'Jl. Melati No. 12, Bandung',        'bio' => 'Pelajar yang suka film aksi dan fantasi.'],
            ['umur' => 19, 'alamat' => 'Jl. Kenanga No. 5, Jakarta Selatan', 'bio' => 'Mahasiswi komunikasi, penggemar drama dan romansa.'],
            ['umur' => 22, 'alamat' => 'Jl. Dago Atas No. 88, Bandung',      'bio' => 'Editor video lepas, suka sinematografi.'],
            ['umur' => 25, 'alamat' => 'Jl. Pemuda No. 41, Semarang',        'bio' => 'Karyawan swasta, hobi nonton akhir pekan.'],
            ['umur' => 18, 'alamat' => 'Jl. Merdeka No. 7, Yogyakarta',      'bio' => 'Suka film horor dan thriller.'],
            ['umur' => 28, 'alamat' => 'Jl. Diponegoro No. 20, Surabaya',    'bio' => 'Penulis blog ulasan film.'],
            ['umur' => 21, 'alamat' => 'Jl. Gajah Mada No. 3, Medan',        'bio' => 'Mahasiswa teknik, penggemar animasi.'],
            ['umur' => 30, 'alamat' => 'Jl. Sudirman No. 99, Makassar',      'bio' => 'Guru bahasa Indonesia, suka film sejarah.'],
            ['umur' => 16, 'alamat' => 'Jl. Anggrek No. 14, Malang',         'bio' => 'Penggemar komedi dan film keluarga.'],
            ['umur' => 24, 'alamat' => 'Jl. Imam Bonjol No. 61, Denpasar',   'bio' => 'Barista dan pecinta film dokumenter.'],
        ];

        foreach ($data as $row) {
            Profile::create($row);
        }
    }
}
