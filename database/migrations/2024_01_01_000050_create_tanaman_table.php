<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lahan_id')->constrained('lahan')->cascadeOnDelete();
            $table->foreignId('anggota_id')->constrained('anggota')->cascadeOnDelete();

            // Data Porang
            $table->enum('varietas', [
                'Amorphophallus muelleri',
                'Amorphophallus campanulatus',
                'Amorphophallus oncophyllus',
                'Lainnya'
            ])->default('Amorphophallus muelleri');

            $table->enum('sumber_bibit', ['katak/bulbil', 'umbi', 'biji', 'kultur jaringan'])->default('katak/bulbil');
            $table->integer('jumlah_bibit');
            $table->decimal('luas_tanam', 10, 2)->nullable();
            $table->string('jarak_tanam')->nullable(); // misal: 100x100 cm

            $table->date('tanggal_tanam');
            $table->date('estimasi_panen')->nullable();
            $table->date('tanggal_panen_aktual')->nullable();

            $table->enum('status', ['persiapan', 'tanam', 'tumbuh', 'panen', 'gagal'])->default('tanam');
            $table->integer('umur_tanam_bulan')->nullable(); // umur tanaman saat ini dalam bulan

            $table->string('pupuk_digunakan')->nullable();
            $table->string('pestisida_digunakan')->nullable();
            $table->text('kendala')->nullable();
            $table->text('catatan')->nullable();
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanaman');
    }
};
