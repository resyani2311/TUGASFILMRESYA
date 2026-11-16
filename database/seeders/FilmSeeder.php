<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /** Pool nama tokoh untuk sinopsis. */
    private array $tokoh = ['Raka', 'Laras', 'Bima', 'Sekar', 'Arga', 'Dewi', 'Satria', 'Nadia', 'Wira', 'Kirana', 'Damar', 'Maya'];

    /** Template sinopsis per genre_id. {t} = judul, {n} = nama tokoh, {m} = nama tokoh lain. */
    private array $templates = [
        1  => ['{n} harus menghentikan komplotan bersenjata yang mengancam kota sebelum matahari terbit.', 'Dikejar waktu, {n} dan {m} terlibat aksi kejar-kejaran penuh ledakan demi merebut kembali barang yang dicuri.', 'Mantan agen khusus {n} dipaksa kembali bertugas ketika organisasi lamanya menjadi target serangan.'],
        2  => ['Kisah nyata perjalanan hidup {n}, dari masa kecil yang sulit hingga menjadi tokoh yang menginspirasi banyak orang.', '{n} menempuh jalan terjal untuk mewujudkan mimpinya, ditemani {m} yang selalu percaya padanya.', 'Berdasarkan kisah sejati, film ini mengikuti pergulatan batin {n} di tengah tekanan keluarga dan masyarakat.'],
        3  => ['Detektif {n} menelusuri jaringan kejahatan yang ternyata melibatkan orang-orang terdekatnya.', '{n} dan {m} merencanakan pencurian terbesar di kota, namun satu pengkhianatan mengubah segalanya.', 'Sebuah kasus pembunuhan misterius menyeret {n} ke dunia bawah tanah yang penuh intrik.'],
        4  => ['{n} dan keluarganya belajar arti kebersamaan saat liburan sederhana berubah menjadi petualangan tak terlupakan.', 'Hubungan hangat antara {n} dan kakeknya diuji ketika rumah keluarga terancam dijual.', 'Keluarga kecil {n} menemukan kejutan manis yang mempererat seluruh anggota keluarga.'],
        5  => ['{n} dan teman-temannya terjebak di rumah tua yang menyimpan rahasia kelam dan sosok yang tak ingin dibangunkan.', 'Setiap malam, suara aneh dari lantai atas membuat {n} yakin ada yang tidak beres dengan rumah barunya.', 'Sebuah ritual terlarang membangkitkan teror yang memburu {n} dan {m} hingga fajar.'],
        6  => ['Pertemuan tak sengaja antara {n} dan {m} menumbuhkan cinta yang harus melewati restu keluarga dan jarak.', '{n} akhirnya jatuh cinta pada sahabatnya sendiri, tepat ketika {m} akan pindah ke luar negeri.', 'Dua hati yang berbeda dunia bertemu di musim hujan, mencari arti kata setia.'],
        7  => ['{n} berjuang bangkit dari cedera panjang demi membawa timnya menuju final nasional.', 'Pelatih {n} menyulap tim underdog menjadi juara lewat latihan keras dan kerja sama.', 'Persaingan sengit antara {n} dan {m} menguji persahabatan dan sportivitas keduanya.'],
        8  => ['Di tengah medan perang, prajurit {n} berjuang menjaga pasukannya tetap hidup.', '{n} mengemban misi berbahaya menembus garis musuh demi menyelamatkan rekan-rekannya.', 'Kisah keberanian dan pengorbanan {n} di garis depan pertempuran yang tak terlupakan.'],
        9  => ['{n} dan {m} menjelajah hutan, gunung, dan laut untuk mencari peta harta karun yang hilang.', 'Perjalanan nekat {n} menembus pedalaman membawanya pada rahasia peradaban kuno.', 'Sekelompok sahabat memulai ekspedisi penuh bahaya demi menemukan pulau yang tak ada di peta.'],
        10 => ['Kekacauan demi kekacauan menimpa {n} yang hanya ingin hari biasa, dan membuat seisi kota tertawa.', '{n} dan {m} berpura-pura menjadi orang lain demi pekerjaan impian, dan semuanya berantakan.', 'Komedi segar tentang {n} yang salah paham pada hampir segala hal.'],
        11 => ['Dokumenter ini menyorot kehidupan {n} dan komunitasnya lewat wawancara dan rekaman langsung.', 'Tim peneliti mengikuti perjalanan {n} selama bertahun-tahun, menyingkap sisi yang jarang diketahui publik.', 'Potret jujur tentang alam dan manusia yang bergantung padanya, dituturkan oleh {n}.'],
        12 => ['{n} menemukan pintu menuju dunia sihir dan harus menyelamatkannya dari kutukan kuno.', 'Di negeri yang dihuni makhluk legenda, {n} dan {m} mencari tongkat pemilik kekuatan sejati.', 'Seorang yatim bernama {n} ternyata keturunan penyihir terakhir yang dinanti sebuah kerajaan.'],
        13 => ['{n} sadar sedang diawasi, dan setiap orang di sekelilingnya tampak menyembunyikan sesuatu.', 'Sebuah pesan misterius memulai permainan maut yang memaksa {n} mengambil keputusan dalam hitungan menit.', 'Terkunci di gedung tertutup, {n} dan {m} harus mencari pelaku sebelum waktu habis.'],
        14 => ['Petualangan lucu {n} dan sahabat-sahabatnya yang tak pernah menyerah menghadapi dunia yang luas.', '{n}, makhluk kecil bernyali besar, bertekad menemukan jalan pulang ke rumahnya.', 'Dengan animasi penuh warna, {n} belajar bahwa keberanian datang dari hati.'],
        15 => ['Berlatar kerajaan masa lampau, {n} terjebak intrik istana dan cinta terlarang dengan {m}.', 'Kostum megah dan tradisi lama mengiringi perjuangan {n} mempertahankan kehormatan keluarganya.', 'Seorang bangsawan muda, {n}, harus memilih antara tahta dan hati nuraninya.'],
        16 => ['{n} menghadapi keputusan paling berat dalam hidupnya setelah rahasia keluarga terbongkar.', 'Drama mengharukan tentang {n} yang berdamai dengan masa lalu dan orang-orang yang pernah disakitinya.', 'Hubungan {n} dan {m} diuji oleh kehilangan, harapan, dan kesempatan kedua.'],
        17 => ['Menghidupkan kembali peristiwa bersejarah lewat sudut pandang {n} yang hidup di masa itu.', '{n} menjadi saksi perubahan besar yang mengubah wajah negerinya.', 'Film sejarah tentang perjuangan {n} dan para sahabatnya meraih kebebasan.'],
        18 => ['{n} mengejar impian menjadi penyanyi, dan setiap langkahnya diiringi lagu-lagu indah.', 'Panggung teater kecil menjadi tempat {n} dan {m} menemukan cinta dan jati diri lewat musik.', 'Sebuah grup musik sederhana bangkit dari nol, dari ruang latihan sempit hingga panggung besar.'],
        19 => ['{n} mulai meragukan ingatannya sendiri ketika batas antara kenyataan dan mimpi semakin kabur.', 'Terapis {m} menyelami pikiran {n} dan menemukan trauma yang selama ini terkubur.', 'Sebuah thriller psikologis tentang {n} yang terperangkap dalam bayangan pikirannya.'],
    ];

    public function run(): void
    {
        $file = fopen(base_path('database/data/movies.csv'), 'r');
        $first = true;
        $i = 0;

        while (($data = fgetcsv($file, 500, ';')) !== false) {
            if ($first) { $first = false; continue; }
            [$poster, $title, $year, $genreId] = $data;
            if (str_starts_with($poster, 'storage/images/')) {
                $poster = 'template/images/'.basename($poster);
            }

            $tpl = $this->templates[(int) $genreId] ?? $this->templates[16];
            $n = $this->tokoh[$i % count($this->tokoh)];
            $m = $this->tokoh[($i + 5) % count($this->tokoh)];

            $kalimat = str_replace(['{n}', '{m}'], [$n, $m], $tpl[$i % 3]);
            $penutup = [
                'Sebuah tontonan yang layak ditunggu sepanjang tahun ini.',
                'Dibalut sinematografi apik dan musik yang membekas.',
                'Film yang akan membuat Anda terus bertanya hingga akhir.',
            ][($i + (int) $genreId) % 3];

            Film::create([
                'poster'   => $poster,
                'title'    => $title,
                'year'     => $year,
                'genre_id' => $genreId,
                'sinopsis' => "{$title}: {$kalimat} {$penutup}",
            ]);
            $i++;
        }

        fclose($file);
    }
}
