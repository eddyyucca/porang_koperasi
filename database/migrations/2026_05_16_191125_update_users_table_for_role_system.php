<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Extend role enum to include admin_desa and bumdes
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin','operator','petani','admin_desa','bumdes') NOT NULL DEFAULT 'operator'");

        Schema::table('users', function (Blueprint $table) {
            // Wilayah assignment for admin_desa
            $table->string('wilayah_kabupaten_id')->nullable()->after('role');
            $table->string('wilayah_kabupaten_nama')->nullable()->after('wilayah_kabupaten_id');
            $table->string('wilayah_kecamatan_id')->nullable()->after('wilayah_kabupaten_nama');
            $table->string('wilayah_kecamatan_nama')->nullable()->after('wilayah_kecamatan_id');
            $table->string('wilayah_desa_id')->nullable()->after('wilayah_kecamatan_nama');
            $table->string('wilayah_desa_nama')->nullable()->after('wilayah_desa_id');

            // Link to anggota (for petani role)
            $table->foreignId('anggota_id')->nullable()->after('wilayah_desa_nama')
                ->constrained('anggota')->nullOnDelete();

            // Link to bumdes (for bumdes role)
            $table->foreignId('bumdes_id')->nullable()->after('anggota_id')
                ->constrained('bumdes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['anggota_id']);
            $table->dropForeign(['bumdes_id']);
            $table->dropColumn([
                'wilayah_kabupaten_id', 'wilayah_kabupaten_nama',
                'wilayah_kecamatan_id', 'wilayah_kecamatan_nama',
                'wilayah_desa_id', 'wilayah_desa_nama',
                'anggota_id', 'bumdes_id',
            ]);
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin','admin','operator','petani') NOT NULL DEFAULT 'operator'");
    }
};
