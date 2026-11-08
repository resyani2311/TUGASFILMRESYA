<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Di lingkungan lokal, buat symlink public/storage otomatis bila belum ada
        // (agar poster/foto tampil tanpa harus menjalankan `php artisan storage:link` manual).
        if ($this->app->isLocal() && ! file_exists(public_path('storage')) && ! is_link(public_path('storage'))) {
            try {
                $this->app['files']->link(storage_path('app/public'), public_path('storage'));
            } catch (\Throwable) {
                // Abaikan: jalankan `php artisan storage:link` secara manual jika gagal.
            }
        }
    }
}
