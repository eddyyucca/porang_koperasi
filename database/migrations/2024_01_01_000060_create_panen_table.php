<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tanaman_id')->constrained('tanaman')->cascadeOnDelete();
            $table->foreignId('lahan_id')->constrained('lahan')->cascadeOnDelete();
            $table->foreignId('anggota_id')->constrained('anggota')->cascadeOnDelete();

            $table->date('tanggal_panen');
            $table->decimal('berat_panen_kg', 10, 2);
            $table->enum('kualitas', ['Grade A', 'Grade B', 'Grade C'])->default('Grade A');

            // Nilai Jual
            $table->decimal('harga_per_kg', 12, 2)->nullable();
            $table->decimal('total_nilai', 15, 2)->nullable();

            // Pemasaran
            $table->string('pembeli')->nullable();
            $table->enum('metode_jual', ['koperasi', 'pasar', 'tengkulak', 'ekspor', 'langsung'])->default('koperasi');
            $table->enum('status_jual', ['belum terjual', 'sebagian', 'terjual'])->default('belum terjual');

            $table->text('catatan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panen');
    }
};
