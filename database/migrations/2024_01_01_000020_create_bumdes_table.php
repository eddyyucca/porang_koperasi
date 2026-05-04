<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bumdes', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->text('alamat');
            $table->string('provinsi_id', 10)->nullable();
            $table->string('provinsi_nama')->nullable();
            $table->string('kabupaten_id', 10)->nullable();
            $table->string('kabupaten_nama')->nullable();
            $table->string('kecamatan_id', 10)->nullable();
            $table->string('kecamatan_nama')->nullable();
            $table->string('desa_id', 10)->nullable();
            $table->string('desa_nama')->nullable();
            $table->string('direktur')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('rekening_bank')->nullable();
            $table->string('nama_bank')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bumdes');
    }
};
