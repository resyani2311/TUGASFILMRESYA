<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Satu user hanya punya satu komentar per film (mencegah data duplikat).
     * Jika sudah ada duplikat lama, komentar terbaru dipertahankan.
     */
    public function up(): void
    {
        $keepIds = DB::table('kritiks')
            ->selectRaw('MAX(id) as id')
            ->groupBy('user_id', 'film_id')
            ->pluck('id');

        DB::table('kritiks')->whereNotIn('id', $keepIds)->delete();

        Schema::table('kritiks', function (Blueprint $table) {
            $table->unique(['user_id', 'film_id']);
        });
    }

    public function down(): void
    {
        Schema::table('kritiks', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'film_id']);
        });
    }
};
