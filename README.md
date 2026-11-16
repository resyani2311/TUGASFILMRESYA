# OneMovies — Laravel Kelas XII

Aplikasi review film (Laravel 13, PHP 8.4+) dengan dua jenis pengguna.

## Aturan aplikasi

| User biasa | Administrator |
|---|---|
| Melihat list film langsung di dashboard (beranda, daftar film, genre, pencarian) | CRUD data **film, cast, genre & peran** |
| Memberi komentar/kritik + rating untuk film | **Tidak bisa** memberi komentar pada film |
| Melihat & mengubah halaman profile sendiri | Melihat **list data user** (read-only) |

## Akun bawaan (hasil seeder)

| Role | Email | Password |
|---|---|---|
| Administrator | `admin@example.com` | `12345678` |
| User biasa | `budi@example.com` (juga siti, andi, dewi, rizky, putri, fajar, ayu, dimas, nanda `@example.com`) | `12345678` |

Pengunjung juga bisa mendaftar sendiri lewat menu **Register** (otomatis menjadi user biasa).

## Cara menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Database — pilih salah satu:

* **SQLite (default, tanpa setup):**
  ```bash
  touch database/database.sqlite
  ```
* **MySQL:** buat database kosong, lalu di `.env` ubah `DB_CONNECTION=mysql` dan isi `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

Lalu:

```bash
php artisan migrate:fresh --seed     # buat tabel + isi data (128 film, 60 cast, ±500 peran, 10 user, 700 komentar)
php artisan storage:link             # diperlukan agar poster yang di-upload admin tampil
php artisan serve
```

Buka http://127.0.0.1:8000 — login admin lewat tombol **Login**, panel admin ada di http://127.0.0.1:8000/admin

> Poster bawaan berada di `public/template/images` dan langsung tampil setelah seeding. Poster film yang di-upload admin disimpan di `storage/app/public/images`, sehingga perlu `php artisan storage:link`. Data film lama yang memakai jalur `storage/images/` juga otomatis diarahkan ke poster bawaan yang tersedia.

## Struktur fitur

| Fitur | Route | Controller |
|---|---|---|
| Beranda / daftar film / detail / genre / cari (`?q=`) | `/`, `/movies`, `/movies/{id}`, `/movies/genre/{id}` | `FilmController` |
| Login, register, logout | `/login`, `/register`, `/logout` | `AuthController` |
| Komentar & rating (user biasa saja) | `POST /movies/{id}/kritik` | `KritikController` |
| Profile sendiri | `/profile`, `/profile/edit` | `ProfileController` |
| Admin: dashboard | `/admin` | `Admin\DashboardController` |
| Admin: CRUD film | `/admin/films` | `FilmController` |
| Admin: CRUD cast | `/admin/casts` | `CastController` |
| Admin: CRUD genre | `/admin/genres` | `GenreController` |
| Admin: CRUD peran | `/admin/perans` | `PeranController` |
| Admin: list user | `/admin/users` | `UserController` |

Pembatasan akses memakai middleware `role` (`app/Http/Middleware/RoleMiddleware.php`):
`role:user` untuk komentar, `role:admin` untuk semua halaman `/admin/*`. Selain di route, validasi juga ada di `FormRequest` (admin tidak lolos `StoreKritikRequest`).

API bawaan materi (`/api/movie`) tidak diubah.
