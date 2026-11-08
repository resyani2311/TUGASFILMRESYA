<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Pastikan role "admin" dan "user" ada, lalu beri role "user" kepada
     * akun lama yang belum punya role. Data lama tidak dihapus.
     */
    public function up(): void
    {
        foreach (['admin', 'user'] as $name) {
            if (! DB::table('roles')->where('name', $name)->exists()) {
                DB::table('roles')->insert(['name' => $name, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');

        DB::table('users')->whereNull('role_id')->update(['role_id' => $userRoleId]);
    }

    public function down(): void
    {
        // Sengaja kosong: data role tidak dihapus agar akun tidak kehilangan role.
    }
};
