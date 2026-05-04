<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('koperasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_badan_hukum')->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->text('alamat');
            $table->string('provinsi_id', 10)->nullable();
            $table->string('provinsi_nama')->nullable();
            $table->string('kabupaten_id', 10)->nullable();
            $table->string('kabupaten_nama')->nullable();
            $table->string('kecamatan_id', 10)->nullable();
            $table->string('kecamatan_nama')->nullable();
            $table->string('desa_id', 10)->nullable();
            $table->string('desa_nama')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('ketua')->nullable();
            $table->string('sekretaris')->nullable();
            $table->string('bendahara')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koperasi');
    }
};
