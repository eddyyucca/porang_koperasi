<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_anggota')->unique();
            $table->enum('jenis_anggota', ['personal', 'bumdes'])->default('personal');
            $table->foreignId('bumdes_id')->nullable()->constrained('bumdes')->nullOnDelete();

            // Data KTP
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-'])->default('-');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'])->default('Islam');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'])->default('Belum Kawin');
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan_ktp')->nullable();
            $table->string('kewarganegaraan', 10)->default('WNI');

            // Alamat KTP
            $table->text('alamat_ktp');
            $table->string('rt_ktp', 5)->nullable();
            $table->string('rw_ktp', 5)->nullable();
            $table->string('desa_id_ktp', 15)->nullable();
            $table->string('desa_ktp')->nullable();
            $table->string('kecamatan_id_ktp', 15)->nullable();
            $table->string('kecamatan_ktp')->nullable();
            $table->string('kabupaten_id_ktp', 10)->nullable();
            $table->string('kabupaten_ktp')->nullable();
            $table->string('provinsi_id_ktp', 10)->nullable();
            $table->string('provinsi_ktp')->nullable();
            $table->string('kode_pos_ktp', 10)->nullable();

            // Alamat Domisili (optional, sama dengan KTP jika kosong)
            $table->text('alamat_domisili')->nullable();
            $table->string('rt_domisili', 5)->nullable();
            $table->string('rw_domisili', 5)->nullable();
            $table->string('desa_domisili')->nullable();
            $table->string('kecamatan_domisili')->nullable();
            $table->string('kabupaten_domisili')->nullable();
            $table->string('provinsi_domisili')->nullable();

            // Kontak & Dokumen
            $table->string('telepon', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_diri')->nullable();

            // Perbankan
            $table->string('no_rekening')->nullable();
            $table->string('nama_bank')->nullable();

            // Keanggotaan Koperasi
            $table->foreignId('koperasi_id')->nullable()->constrained('koperasi')->nullOnDelete();
            $table->date('tanggal_daftar');
            $table->enum('status', ['aktif', 'non-aktif', 'pending'])->default('pending');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
