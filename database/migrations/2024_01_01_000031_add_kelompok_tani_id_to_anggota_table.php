<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->foreignId('kelompok_tani_id')
                ->nullable()
                ->after('bumdes_id')
                ->constrained('kelompok_tani')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropForeign(['kelompok_tani_id']);
            $table->dropColumn('kelompok_tani_id');
        });
    }
};
