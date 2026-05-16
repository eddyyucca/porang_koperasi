<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // BUMDes-owned lahan has no individual anggota
        DB::statement('ALTER TABLE tanaman MODIFY anggota_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE panen MODIFY anggota_id BIGINT UNSIGNED NULL');
        DB::statement("ALTER TABLE anggota MODIFY jenis_anggota ENUM('personal','bumdes','kelompok_tani') NOT NULL DEFAULT 'personal'");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE tanaman MODIFY anggota_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE panen MODIFY anggota_id BIGINT UNSIGNED NOT NULL');
        DB::statement("ALTER TABLE anggota MODIFY jenis_anggota ENUM('personal','bumdes') NOT NULL DEFAULT 'personal'");
    }
};
