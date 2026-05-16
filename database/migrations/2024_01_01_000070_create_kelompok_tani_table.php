<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_tani', function (Blueprint $table) {
            $table->id();

            // Identitas Kelompok
            $table->string('nama_kelompok', 150);
            $table->string('nomor_sk', 100)->nullable();    // SK pembentukan kelompok tani

            // Pengurus
            $table->string('ketua_nama', 100);
            $table->string('ketua_nik', 16)->nullable();
            $table->string('ketua_telepon', 20)->nullable();
            $table->string('sekretaris', 100)->nullable();
            $table->string('bendahara', 100)->nullable();

            // Wilayah
            $table->string('provinsi_id', 15)->nullable();
            $table->string('provinsi_nama', 100)->nullable();
            $table->string('kabupaten_id', 15)->nullable();
            $table->string('kabupaten_nama', 100)->nullable();
            $table->string('kecamatan_id', 15)->nullable();
            $table->string('kecamatan_nama', 100)->nullable();
            $table->string('desa_id', 15)->nullable();
            $table->string('desa_nama', 100)->nullable();
            $table->text('alamat')->nullable();

            // Info Kelompok
            $table->year('tahun_berdiri')->nullable();
            $table->integer('jumlah_anggota')->default(0);
            $table->string('komoditas_utama', 100)->default('Porang');
            $table->decimal('luas_lahan_total', 10, 2)->default(0); // total lahan dalam m2

            // Asosiasi
            $table->foreignId('bumdes_id')->nullable()->constrained('bumdes')->nullOnDelete();
            $table->foreignId('koperasi_id')->nullable()->constrained('koperasi')->nullOnDelete();

            // Status & Administrasi
            $table->enum('status', ['pending', 'aktif', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();  // admin notes (reason for approval/rejection)
            $table->string('foto')->nullable();   // group photo

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_tani');
    }
};
