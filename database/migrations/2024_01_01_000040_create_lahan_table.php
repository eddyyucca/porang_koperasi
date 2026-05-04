<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->cascadeOnDelete();
            $table->string('nama_lahan');
            $table->decimal('luas_lahan', 10, 2);
            $table->enum('satuan_luas', ['m2', 'ha', 'are'])->default('m2');

            // Lokasi Wilayah
            $table->string('provinsi_id', 10)->nullable();
            $table->string('provinsi_nama')->nullable();
            $table->string('kabupaten_id', 10)->nullable();
            $table->string('kabupaten_nama')->nullable();
            $table->string('kecamatan_id', 10)->nullable();
            $table->string('kecamatan_nama')->nullable();
            $table->string('desa_id', 15)->nullable();
            $table->string('desa_nama')->nullable();
            $table->text('alamat_lahan')->nullable();

            // Koordinat (titik tengah lahan)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // GeoJSON polygon (optional)
            $table->longText('geojson')->nullable();

            // Status & Dokumen
            $table->enum('status_kepemilikan', ['milik sendiri', 'sewa', 'gadai', 'pinjam'])->default('milik sendiri');
            $table->string('jenis_dokumen')->nullable();
            $table->string('nomor_dokumen')->nullable();
            $table->string('dokumen_file')->nullable();

            $table->enum('kondisi_tanah', ['subur', 'cukup subur', 'kurang subur'])->default('subur');
            $table->boolean('aktif')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lahan');
    }
};
