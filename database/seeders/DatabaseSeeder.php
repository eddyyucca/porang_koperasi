<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Koperasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@koperasi.id'],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'aktif'    => true,
            ]
        );

        // Operator user
        User::updateOrCreate(
            ['email' => 'operator@koperasi.id'],
            [
                'name'     => 'Operator',
                'password' => Hash::make('operator123'),
                'role'     => 'operator',
                'aktif'    => true,
            ]
        );

        // Data koperasi awal
        Koperasi::updateOrCreate(
            ['nama' => 'Koperasi Tani Makmur Porang'],
            [
                'nomor_badan_hukum' => '001/KOP/2020',
                'tanggal_berdiri'   => '2020-01-15',
                'alamat'            => 'Jl. Raya Pertanian No. 1',
                'provinsi_nama'     => 'Jawa Timur',
                'kabupaten_nama'    => 'Madiun',
                'kecamatan_nama'    => 'Mejayan',
                'desa_nama'         => 'Kaligunting',
                'ketua'             => 'Budi Santoso',
                'sekretaris'        => 'Siti Rahayu',
                'bendahara'         => 'Ahmad Fauzi',
                'telepon'           => '081234567890',
                'email'             => 'koperasi@porang.id',
                'visi'              => 'Menjadi koperasi tani porang terdepan yang mensejahterakan anggota',
                'misi'              => "1. Meningkatkan produktivitas petani porang\n2. Memperkuat jaringan pemasaran\n3. Memberdayakan ekonomi desa",
                'aktif'             => true,
            ]
        );

        $this->call(TapinDummySeeder::class);
    }
}
