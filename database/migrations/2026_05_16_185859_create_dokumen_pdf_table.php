<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_pdf', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('file_path');
            $table->unsignedBigInteger('ukuran')->nullable(); // bytes
            $table->string('deskripsi', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_pdf');
    }
};
