<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Extend status enum: add tunda & siap_panen
        DB::statement("ALTER TABLE tanaman MODIFY COLUMN status ENUM('persiapan','tanam','tumbuh','siap_panen','panen','tunda','gagal') NOT NULL DEFAULT 'tanam'");

        Schema::table('tanaman', function (Blueprint $table) {
            // Numeric spacing for stem count calculation (default porang 100x100cm)
            $table->unsignedSmallInteger('jarak_tanam_x_cm')->default(100)->after('jarak_tanam');
            $table->unsignedSmallInteger('jarak_tanam_y_cm')->default(100)->after('jarak_tanam_x_cm');
            $table->unsignedInteger('estimasi_batang')->nullable()->after('jarak_tanam_y_cm');

            // Petani action: confirm planting
            $table->timestamp('konfirmasi_tanam_at')->nullable()->after('tanggal_tanam');
            $table->foreignId('konfirmasi_tanam_user_id')->nullable()->after('konfirmasi_tanam_at')
                ->constrained('users')->nullOnDelete();

            // Tunda panen fields (before estimasi_panen column)
            $table->date('tunda_tanggal_baru')->nullable()->after('estimasi_panen');
            $table->text('tunda_alasan')->nullable()->after('tunda_tanggal_baru');
            $table->text('gagal_alasan')->nullable()->after('tunda_alasan');

            // Petani action: confirm harvest
            $table->timestamp('konfirmasi_panen_at')->nullable()->after('tanggal_panen_aktual');
            $table->foreignId('konfirmasi_panen_user_id')->nullable()->after('konfirmasi_panen_at')
                ->constrained('users')->nullOnDelete();

            // Harvest result (snapshot harga saat panen)
            $table->decimal('harga_per_kg_panen', 12, 2)->nullable()->after('konfirmasi_panen_user_id');
            $table->decimal('berat_panen_kg', 10, 2)->nullable()->after('harga_per_kg_panen');
            $table->decimal('total_nilai_panen', 15, 2)->nullable()->after('berat_panen_kg');
            $table->enum('kualitas_panen', ['Grade A', 'Grade B', 'Grade C'])->nullable()->after('total_nilai_panen');
        });
    }

    public function down(): void
    {
        Schema::table('tanaman', function (Blueprint $table) {
            $table->dropForeign(['konfirmasi_tanam_user_id']);
            $table->dropForeign(['konfirmasi_panen_user_id']);
            $table->dropColumn([
                'jarak_tanam_x_cm', 'jarak_tanam_y_cm', 'estimasi_batang',
                'konfirmasi_tanam_at', 'konfirmasi_tanam_user_id',
                'tunda_tanggal_baru', 'tunda_alasan', 'gagal_alasan',
                'konfirmasi_panen_at', 'konfirmasi_panen_user_id',
                'harga_per_kg_panen', 'berat_panen_kg', 'total_nilai_panen', 'kualitas_panen',
            ]);
        });

        DB::statement("ALTER TABLE tanaman MODIFY COLUMN status ENUM('persiapan','tanam','tumbuh','panen','gagal') NOT NULL DEFAULT 'tanam'");
    }
};
