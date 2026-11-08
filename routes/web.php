<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik / tamu (belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/forgot-password', 'auth.forgot-password')->name('forgot-password');
});

Route::view('/terms', 'auth.terms')->name('terms');

/*
|--------------------------------------------------------------------------
| Halaman yang wajib login (user biasa maupun admin)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Film: hanya melihat daftar & detail.
    Route::get('/film', [FilmController::class, 'index'])->name('film.index');
    Route::get('/film/{film}', [FilmController::class, 'show'])->name('film.show');

    // Profile milik sendiri (tanpa parameter id, sehingga tidak bisa membuka profile orang lain).
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Komentar/kritik: HANYA user biasa (admin ditolak 403 oleh middleware di backend).
    Route::middleware('role:user')->group(function () {
        Route::post('/film/{film}/kritik', [KritikController::class, 'store'])->name('kritik.store');
        Route::delete('/kritik/{kritik}', [KritikController::class, 'destroy'])->name('kritik.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Panel Administrator (hanya role admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('film', Admin\FilmController::class);
    Route::resource('cast', Admin\CastController::class);
    Route::resource('genre', Admin\GenreController::class);
    Route::resource('actor', Admin\ActorController::class);

    // Admin hanya boleh melihat daftar user.
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
});
