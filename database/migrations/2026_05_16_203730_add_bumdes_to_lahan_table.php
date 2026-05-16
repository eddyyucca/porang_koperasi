<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Make anggota_id nullable so BUMDes-owned land has no individual petani owner
        DB::statement('ALTER TABLE lahan MODIFY anggota_id BIGINT UNSIGNED NULL');

        Schema::table('lahan', function (Blueprint $table) {
            $table->enum('pemilik_type', ['petani', 'bumdes'])->default('petani')->after('anggota_id');
            $table->foreignId('bumdes_id')->nullable()->after('pemilik_type')
                  ->constrained('bumdes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lahan', function (Blueprint $table) {
            $table->dropForeign(['bumdes_id']);
            $table->dropColumn(['pemilik_type', 'bumdes_id']);
        });
        DB::statement('ALTER TABLE lahan MODIFY anggota_id BIGINT UNSIGNED NOT NULL');
    }
};
