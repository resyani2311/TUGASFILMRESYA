<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\{
    AuthController,
    CastController,
    FilmController,
    GenreController,
    KritikController,
    PeranController,
    ProfileController,
    UserController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publik (user biasa melihat list film langsung di dashboard)
|--------------------------------------------------------------------------
*/
Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show')->whereNumber('film');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre')->whereNumber('genre');

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile milik sendiri (user biasa & admin)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| User biasa : memberi komentar/kritik (admin TIDAK boleh)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/movies/{film}/kritik', [KritikController::class, 'store'])->name('kritik.store');
});

/*
|--------------------------------------------------------------------------
| Administrator : CRUD film, cast, genre, peran + lihat daftar user
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('films', FilmController::class)->except('show')->names('admin.films');
    Route::resource('casts', CastController::class)->except('show')->names('admin.casts');
    Route::resource('genres', GenreController::class)->except('show')->names('admin.genres');
    Route::resource('perans', PeranController::class)->except('show')->names('admin.perans');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
});
