<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Bumdes;
use App\Models\HargaPorang;
use App\Models\KelompokTani;
use App\Models\Koperasi;
use App\Models\Lahan;
use App\Models\Panen;
use App\Models\Tanaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KalselDummySeeder extends Seeder
{
    public function run(): void
    {
        // ── Bersihkan semua data ───────────────────────────────────
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('panen')->truncate();
        DB::table('tanaman')->truncate();
        DB::table('lahan')->truncate();
        DB::table('anggota')->truncate();
        DB::table('kelompok_tani')->truncate();
        DB::table('bumdes')->truncate();
        DB::table('koperasi')->truncate();
        DB::table('harga_porang')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ── Users ──────────────────────────────────────────────────
        $superadmin = User::create([
            'name'     => 'Super Admin KBPB',
            'email'    => 'superadmin@kbpb.id',
            'password' => Hash::make('kbpb1234'),
            'role'     => 'superadmin',
            'aktif'    => true,
        ]);

        $admin = User::create([
            'name'     => 'Admin Koperasi',
            'email'    => 'admin@kbpb.id',
            'password' => Hash::make('kbpb1234'),
            'role'     => 'admin',
            'aktif'    => true,
        ]);

        $operator = User::create([
            'name'     => 'Operator Koperasi',
            'email'    => 'operator@kbpb.id',
            'password' => Hash::make('kbpb1234'),
            'role'     => 'operator',
            'aktif'    => true,
        ]);

        $adminTapin = User::create([
            'name'                  => 'Penanggung Jawab Kab. Tapin',
            'email'                 => 'pj.tapin@kbpb.id',
            'password'              => Hash::make('kbpb1234'),
            'role'                  => 'admin_desa',
            'aktif'                 => true,
            'wilayah_kabupaten_nama' => 'Tapin',
        ]);

        $adminHSS = User::create([
            'name'                  => 'Penanggung Jawab Kab. HSS',
            'email'                 => 'pj.hss@kbpb.id',
            'password'              => Hash::make('kbpb1234'),
            'role'                  => 'admin_desa',
            'aktif'                 => true,
            'wilayah_kabupaten_nama' => 'Hulu Sungai Selatan',
        ]);

        $adminHST = User::create([
            'name'                  => 'Penanggung Jawab Kab. HST',
            'email'                 => 'pj.hst@kbpb.id',
            'password'              => Hash::make('kbpb1234'),
            'role'                  => 'admin_desa',
            'aktif'                 => true,
            'wilayah_kabupaten_nama' => 'Hulu Sungai Tengah',
        ]);

        $adminBanjar = User::create([
            'name'                  => 'Penanggung Jawab Kab. Banjar',
            'email'                 => 'pj.banjar@kbpb.id',
            'password'              => Hash::make('kbpb1234'),
            'role'                  => 'admin_desa',
            'aktif'                 => true,
            'wilayah_kabupaten_nama' => 'Banjar',
        ]);

        // ── Koperasi ───────────────────────────────────────────────
        $koperasi = Koperasi::create([
            'nama'               => 'Koperasi Barakat Pangan Banua',
            'nomor_badan_hukum'  => '503/BH/KOP/2021/01',
            'tanggal_berdiri'    => '2021-03-15',
            'alamat'             => 'Jl. Ahmad Yani KM 3 No. 18',
            'provinsi_nama'      => 'Kalimantan Selatan',
            'kabupaten_nama'     => 'Tapin',
            'kecamatan_nama'     => 'Rantau',
            'desa_nama'          => 'Rantau Kiwa',
            'ketua'              => 'H. Syarifuddin Noor',
            'sekretaris'         => 'Rahmawati',
            'bendahara'          => 'Muhammad Ihsan',
            'telepon'            => '085251234567',
            'email'              => 'info@barakatpanganbanua.com',
            'visi'               => 'Menjadi koperasi pertanian porang terdepan di Kalimantan Selatan yang mensejahterakan petani dan mendorong ketahanan pangan',
            'misi'               => "1. Meningkatkan produktivitas dan kualitas hasil panen porang\n2. Memperkuat jaringan pemasaran lokal dan ekspor\n3. Memberdayakan petani mandiri dan kelompok tani se-Kalsel\n4. Mengelola lahan desa melalui kemitraan BUMDes",
            'aktif'              => true,
        ]);

        // ── Harga Porang ───────────────────────────────────────────
        HargaPorang::create(['harga_per_kg' => 5000, 'berlaku_mulai' => '2024-01-01', 'keterangan' => 'Harga awal tahun 2024', 'user_id' => $admin->id]);
        HargaPorang::create(['harga_per_kg' => 6000, 'berlaku_mulai' => '2024-06-01', 'keterangan' => 'Kenaikan harga pertengahan 2024', 'user_id' => $admin->id]);
        HargaPorang::create(['harga_per_kg' => 7500, 'berlaku_mulai' => '2025-01-01', 'keterangan' => 'Harga tahun 2025 – permintaan ekspor meningkat', 'user_id' => $admin->id]);
        HargaPorang::create(['harga_per_kg' => 8000, 'berlaku_mulai' => '2025-06-01', 'keterangan' => 'Harga semester 2 – musim panen', 'user_id' => $admin->id]);

        // ── BUMDes ─────────────────────────────────────────────────
        $bumdesTapin = Bumdes::create([
            'nama'          => 'BUMDes Maju Bersama Rantau',
            'nomor_sk'      => '141/SK-BUMDES/TAPIN/2022',
            'tanggal_sk'    => '2022-04-10',
            'alamat'        => 'Jl. Poros Desa Rantau Kiwa No. 5',
            'provinsi_nama' => 'Kalimantan Selatan',
            'kabupaten_nama'=> 'Tapin',
            'kecamatan_nama'=> 'Rantau',
            'desa_nama'     => 'Rantau Kiwa',
            'direktur'      => 'Heri Susanto',
            'telepon'       => '081251100011',
            'email'         => 'bumdes.rantaukiwa@gmail.com',
            'rekening_bank' => '0123456789',
            'nama_bank'     => 'Bank Kalsel',
            'aktif'         => true,
        ]);

        $bumdesHSS = Bumdes::create([
            'nama'          => 'BUMDes Kandangan Makmur',
            'nomor_sk'      => '142/SK-BUMDES/HSS/2022',
            'tanggal_sk'    => '2022-07-20',
            'alamat'        => 'Jl. Negara KM 12, Kandangan',
            'provinsi_nama' => 'Kalimantan Selatan',
            'kabupaten_nama'=> 'Hulu Sungai Selatan',
            'kecamatan_nama'=> 'Kandangan',
            'desa_nama'     => 'Gambah Dalam',
            'direktur'      => 'Norlaila',
            'telepon'       => '081251100022',
            'email'         => 'bumdes.gambah@gmail.com',
            'rekening_bank' => '0234567890',
            'nama_bank'     => 'Bank Kalsel',
            'aktif'         => true,
        ]);

        $bumdesHST = Bumdes::create([
            'nama'          => 'BUMDes Barabai Sejahtera',
            'nomor_sk'      => '143/SK-BUMDES/HST/2023',
            'tanggal_sk'    => '2023-02-14',
            'alamat'        => 'Jl. Trans Kalimantan KM 155, Barabai',
            'provinsi_nama' => 'Kalimantan Selatan',
            'kabupaten_nama'=> 'Hulu Sungai Tengah',
            'kecamatan_nama'=> 'Barabai',
            'desa_nama'     => 'Barabai Darat',
            'direktur'      => 'Rusmadi',
            'telepon'       => '081251100033',
            'email'         => 'bumdes.barabai@gmail.com',
            'rekening_bank' => '0345678901',
            'nama_bank'     => 'BRI',
            'aktif'         => true,
        ]);

        $bumdesBanjar = Bumdes::create([
            'nama'          => 'BUMDes Sungai Tabuk Berkah',
            'nomor_sk'      => '144/SK-BUMDES/BANJAR/2023',
            'tanggal_sk'    => '2023-05-03',
            'alamat'        => 'Jl. Poros Sungai Tabuk No. 8, Martapura',
            'provinsi_nama' => 'Kalimantan Selatan',
            'kabupaten_nama'=> 'Banjar',
            'kecamatan_nama'=> 'Sungai Tabuk',
            'desa_nama'     => 'Pemakuan',
            'direktur'      => 'Fauzan Hamdani',
            'telepon'       => '081251100044',
            'email'         => 'bumdes.sungaitabuk@gmail.com',
            'rekening_bank' => '0456789012',
            'nama_bank'     => 'BNI',
            'aktif'         => true,
        ]);

        // User BUMDes
        $userBumdesTapin = User::create([
            'name'     => 'Heri Susanto (BUMDes Rantau Kiwa)',
            'email'    => 'bumdes.tapin@kbpb.id',
            'password' => Hash::make('kbpb1234'),
            'role'     => 'bumdes',
            'aktif'    => true,
            'bumdes_id'=> $bumdesTapin->id,
        ]);

        $userBumdesHSS = User::create([
            'name'     => 'Norlaila (BUMDes Kandangan)',
            'email'    => 'bumdes.hss@kbpb.id',
            'password' => Hash::make('kbpb1234'),
            'role'     => 'bumdes',
            'aktif'    => true,
            'bumdes_id'=> $bumdesHSS->id,
        ]);

        // ── Kelompok Tani ──────────────────────────────────────────
        $ktTapin = KelompokTani::create([
            'nama_kelompok'   => 'Kelompok Tani Porang Rantau Makmur',
            'nomor_sk'        => 'SK/520/KT-TAPIN/2022/001',
            'ketua_nama'      => 'Ahmad Fauzi',
            'ketua_nik'       => '6305011231800001',
            'ketua_telepon'   => '081252210001',
            'sekretaris'      => 'Siti Aminah',
            'bendahara'       => 'Rahmat',
            'provinsi_nama'   => 'Kalimantan Selatan',
            'kabupaten_nama'  => 'Tapin',
            'kecamatan_nama'  => 'Rantau',
            'desa_nama'       => 'Sungai Pinang',
            'alamat'          => 'Jl. Desa Sungai Pinang RT 03',
            'tahun_berdiri'   => 2022,
            'jumlah_anggota'  => 12,
            'komoditas_utama' => 'Porang (Amorphophallus muelleri)',
            'luas_lahan_total'=> 18500,
            'koperasi_id'     => $koperasi->id,
            'status'          => 'aktif',
            'catatan'         => 'Kelompok tani pertama porang di Tapin, binaan Koperasi Barakat Pangan Banua',
        ]);

        $ktHSS = KelompokTani::create([
            'nama_kelompok'   => 'Kelompok Tani Hulu Sejahtera',
            'nomor_sk'        => 'SK/520/KT-HSS/2023/001',
            'ketua_nama'      => 'M. Sholeh',
            'ketua_nik'       => '6309011231820001',
            'ketua_telepon'   => '081252220001',
            'sekretaris'      => 'Halimatus Sakdiyah',
            'bendahara'       => 'Bahrudin',
            'provinsi_nama'   => 'Kalimantan Selatan',
            'kabupaten_nama'  => 'Hulu Sungai Selatan',
            'kecamatan_nama'  => 'Kandangan',
            'desa_nama'       => 'Tibung Raya',
            'alamat'          => 'Jl. Desa Tibung Raya RT 02',
            'tahun_berdiri'   => 2023,
            'jumlah_anggota'  => 9,
            'komoditas_utama' => 'Porang dan Talas',
            'luas_lahan_total'=> 12000,
            'koperasi_id'     => $koperasi->id,
            'status'          => 'aktif',
            'catatan'         => 'Kelompok tani di wilayah Kandangan, potensi besar lahan gambut',
        ]);

        $ktHST = KelompokTani::create([
            'nama_kelompok'   => 'Kelompok Tani Barabai Maju',
            'nomor_sk'        => 'SK/520/KT-HST/2023/002',
            'ketua_nama'      => 'Sugiono',
            'ketua_nik'       => '6308011231780001',
            'ketua_telepon'   => '081252230001',
            'sekretaris'      => 'Aminah',
            'bendahara'       => 'Yudi Pratama',
            'provinsi_nama'   => 'Kalimantan Selatan',
            'kabupaten_nama'  => 'Hulu Sungai Tengah',
            'kecamatan_nama'  => 'Barabai',
            'desa_nama'       => 'Barabai Utara',
            'alamat'          => 'Jl. Poros Barabai Utara No. 14',
            'tahun_berdiri'   => 2023,
            'jumlah_anggota'  => 8,
            'komoditas_utama' => 'Porang',
            'luas_lahan_total'=> 9800,
            'koperasi_id'     => $koperasi->id,
            'status'          => 'aktif',
        ]);

        // ── Anggota Petani ─────────────────────────────────────────
        // Helper
        $kab = fn(string $k, string $no, string $thn = '2024') => [
            'koperasi_id'  => $koperasi->id,
            'kabupaten_ktp'=> $k,
            'provinsi_ktp' => 'Kalimantan Selatan',
            'agama'        => 'Islam',
            'pendidikan'   => 'SMA/SMK',
            'pekerjaan_ktp'=> 'Petani',
            'kewarganegaraan'=> 'WNI',
            'status'       => 'aktif',
            'tanggal_daftar'=> $thn . '-01-15',
        ];

        // ── TAPIN – Petani Mandiri ──────────────────────────────────
        $a1 = Anggota::create(array_merge($kab('Tapin', '001'), [
            'nik'              => '6305011201810001',
            'nomor_anggota'    => 'KBPB-TAPIN-0001',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'H. Ahmad Syarifudin',
            'tempat_lahir'     => 'Rantau',
            'tanggal_lahir'    => '1981-01-12',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '085251001001',
            'alamat_ktp'       => 'Jl. Sungai Pinang RT 001 RW 001',
            'rt_ktp'           => '001', 'rw_ktp' => '001',
            'desa_ktp'         => 'Sungai Pinang',
            'kecamatan_ktp'    => 'Rantau',
            'kode_pos_ktp'     => '71111',
            'no_rekening'      => '01200100001',
            'nama_bank'        => 'Bank Kalsel',
        ]));

        $a2 = Anggota::create(array_merge($kab('Tapin', '002'), [
            'nik'              => '6305014504890002',
            'nomor_anggota'    => 'KBPB-TAPIN-0002',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'Siti Norhalimah',
            'tempat_lahir'     => 'Tapin',
            'tanggal_lahir'    => '1989-04-05',
            'jenis_kelamin'    => 'P',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '085251001002',
            'alamat_ktp'       => 'Jl. Desa Kupang RT 002 RW 001',
            'rt_ktp'           => '002', 'rw_ktp' => '001',
            'desa_ktp'         => 'Kupang',
            'kecamatan_ktp'    => 'Tapin Selatan',
            'kode_pos_ktp'     => '71112',
            'no_rekening'      => '01200100002',
            'nama_bank'        => 'BRI',
        ]));

        $a3 = Anggota::create(array_merge($kab('Tapin', '003'), [
            'nik'              => '6305010707840003',
            'nomor_anggota'    => 'KBPB-TAPIN-0003',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'Rudi Wahyono',
            'tempat_lahir'     => 'Binuang',
            'tanggal_lahir'    => '1984-07-07',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '085251001003',
            'alamat_ktp'       => 'Jl. Trans KM 24 RT 003 RW 002',
            'rt_ktp'           => '003', 'rw_ktp' => '002',
            'desa_ktp'         => 'Binuang',
            'kecamatan_ktp'    => 'Binuang',
            'kode_pos_ktp'     => '71113',
            'no_rekening'      => '01200100003',
            'nama_bank'        => 'BNI',
        ]));

        // ── TAPIN – Kelompok Tani ───────────────────────────────────
        $a4 = Anggota::create(array_merge($kab('Tapin', '004'), [
            'nik'              => '6305011231800004',
            'nomor_anggota'    => 'KBPB-TAPIN-0004',
            'jenis_anggota'    => 'kelompok_tani',
            'kelompok_tani_id' => $ktTapin->id,
            'nama_lengkap'     => 'Ahmad Fauzi',
            'tempat_lahir'     => 'Rantau',
            'tanggal_lahir'    => '1980-12-31',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '081252210001',
            'alamat_ktp'       => 'Jl. Desa Sungai Pinang RT 003 RW 001',
            'rt_ktp'           => '003', 'rw_ktp' => '001',
            'desa_ktp'         => 'Sungai Pinang',
            'kecamatan_ktp'    => 'Rantau',
            'kode_pos_ktp'     => '71111',
            'no_rekening'      => '01200100004',
            'nama_bank'        => 'Bank Kalsel',
        ]));

        $a5 = Anggota::create(array_merge($kab('Tapin', '005'), [
            'nik'              => '6305014508860005',
            'nomor_anggota'    => 'KBPB-TAPIN-0005',
            'jenis_anggota'    => 'kelompok_tani',
            'kelompok_tani_id' => $ktTapin->id,
            'nama_lengkap'     => 'Mariyam Ulfah',
            'tempat_lahir'     => 'Rantau',
            'tanggal_lahir'    => '1986-08-15',
            'jenis_kelamin'    => 'P',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '081252210002',
            'alamat_ktp'       => 'Jl. Desa Baringin RT 001 RW 002',
            'rt_ktp'           => '001', 'rw_ktp' => '002',
            'desa_ktp'         => 'Baringin',
            'kecamatan_ktp'    => 'Rantau',
            'kode_pos_ktp'     => '71111',
            'no_rekening'      => '01200100005',
            'nama_bank'        => 'BRI',
        ]));

        $a6 = Anggota::create(array_merge($kab('Tapin', '006'), [
            'nik'              => '6305011005920006',
            'nomor_anggota'    => 'KBPB-TAPIN-0006',
            'jenis_anggota'    => 'kelompok_tani',
            'kelompok_tani_id' => $ktTapin->id,
            'nama_lengkap'     => 'Jauhari Effendi',
            'tempat_lahir'     => 'Rantau',
            'tanggal_lahir'    => '1992-05-10',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Belum Kawin',
            'telepon'          => '081252210003',
            'alamat_ktp'       => 'Jl. Desa Sungai Pinang RT 005 RW 002',
            'rt_ktp'           => '005', 'rw_ktp' => '002',
            'desa_ktp'         => 'Sungai Pinang',
            'kecamatan_ktp'    => 'Rantau',
            'kode_pos_ktp'     => '71111',
            'no_rekening'      => '01200100006',
            'nama_bank'        => 'BNI',
        ]));

        // ── HSS – Petani Mandiri ───────────────────────────────────
        $a7 = Anggota::create(array_merge($kab('Hulu Sungai Selatan', '007'), [
            'nik'              => '6309011801830007',
            'nomor_anggota'    => 'KBPB-HSS-0001',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'H. Bahrudin Noor',
            'tempat_lahir'     => 'Kandangan',
            'tanggal_lahir'    => '1983-01-18',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '085252001001',
            'alamat_ktp'       => 'Jl. Gambah Dalam RT 002 RW 001',
            'rt_ktp'           => '002', 'rw_ktp' => '001',
            'desa_ktp'         => 'Gambah Dalam',
            'kecamatan_ktp'    => 'Kandangan',
            'kode_pos_ktp'     => '71211',
            'no_rekening'      => '01200200001',
            'nama_bank'        => 'Bank Kalsel',
        ]));

        $a8 = Anggota::create(array_merge($kab('Hulu Sungai Selatan', '008'), [
            'nik'              => '6309014504910008',
            'nomor_anggota'    => 'KBPB-HSS-0002',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'Nurhidayah',
            'tempat_lahir'     => 'Kandangan',
            'tanggal_lahir'    => '1991-04-05',
            'jenis_kelamin'    => 'P',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '085252001002',
            'alamat_ktp'       => 'Jl. Tibung Raya RT 003 RW 002',
            'rt_ktp'           => '003', 'rw_ktp' => '002',
            'desa_ktp'         => 'Tibung Raya',
            'kecamatan_ktp'    => 'Kandangan',
            'kode_pos_ktp'     => '71212',
            'no_rekening'      => '01200200002',
            'nama_bank'        => 'BRI',
        ]));

        // ── HSS – Kelompok Tani ───────────────────────────────────
        $a9 = Anggota::create(array_merge($kab('Hulu Sungai Selatan', '009'), [
            'nik'              => '6309011231820009',
            'nomor_anggota'    => 'KBPB-HSS-0003',
            'jenis_anggota'    => 'kelompok_tani',
            'kelompok_tani_id' => $ktHSS->id,
            'nama_lengkap'     => 'M. Sholeh',
            'tempat_lahir'     => 'Kandangan',
            'tanggal_lahir'    => '1982-12-31',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '081252220001',
            'alamat_ktp'       => 'Jl. Tibung Raya RT 002 RW 001',
            'rt_ktp'           => '002', 'rw_ktp' => '001',
            'desa_ktp'         => 'Tibung Raya',
            'kecamatan_ktp'    => 'Kandangan',
            'kode_pos_ktp'     => '71212',
            'no_rekening'      => '01200200003',
            'nama_bank'        => 'Bank Kalsel',
        ]));

        $a10 = Anggota::create(array_merge($kab('Hulu Sungai Selatan', '010'), [
            'nik'              => '6309014509900010',
            'nomor_anggota'    => 'KBPB-HSS-0004',
            'jenis_anggota'    => 'kelompok_tani',
            'kelompok_tani_id' => $ktHSS->id,
            'nama_lengkap'     => 'Halimatus Sakdiyah',
            'tempat_lahir'     => 'Kandangan',
            'tanggal_lahir'    => '1990-09-05',
            'jenis_kelamin'    => 'P',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '081252220002',
            'alamat_ktp'       => 'Jl. Sungai Raya RT 004 RW 001',
            'rt_ktp'           => '004', 'rw_ktp' => '001',
            'desa_ktp'         => 'Sungai Raya',
            'kecamatan_ktp'    => 'Simpur',
            'kode_pos_ktp'     => '71213',
            'no_rekening'      => '01200200004',
            'nama_bank'        => 'BNI',
        ]));

        // ── HST – Petani Mandiri ───────────────────────────────────
        $a11 = Anggota::create(array_merge($kab('Hulu Sungai Tengah', '011'), [
            'nik'              => '6308012003790011',
            'nomor_anggota'    => 'KBPB-HST-0001',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'Sugianto',
            'tempat_lahir'     => 'Barabai',
            'tanggal_lahir'    => '1979-03-20',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '085253001001',
            'alamat_ktp'       => 'Jl. Barabai Darat RT 001 RW 001',
            'rt_ktp'           => '001', 'rw_ktp' => '001',
            'desa_ktp'         => 'Barabai Darat',
            'kecamatan_ktp'    => 'Barabai',
            'kode_pos_ktp'     => '71311',
            'no_rekening'      => '01200300001',
            'nama_bank'        => 'Bank Kalsel',
        ]));

        // ── HST – Kelompok Tani ───────────────────────────────────
        $a12 = Anggota::create(array_merge($kab('Hulu Sungai Tengah', '012'), [
            'nik'              => '6308011231780012',
            'nomor_anggota'    => 'KBPB-HST-0002',
            'jenis_anggota'    => 'kelompok_tani',
            'kelompok_tani_id' => $ktHST->id,
            'nama_lengkap'     => 'Sugiono',
            'tempat_lahir'     => 'Barabai',
            'tanggal_lahir'    => '1978-12-31',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '081252230001',
            'alamat_ktp'       => 'Jl. Barabai Utara RT 003 RW 001',
            'rt_ktp'           => '003', 'rw_ktp' => '001',
            'desa_ktp'         => 'Barabai Utara',
            'kecamatan_ktp'    => 'Barabai',
            'kode_pos_ktp'     => '71312',
            'no_rekening'      => '01200300002',
            'nama_bank'        => 'BRI',
        ]));

        $a13 = Anggota::create(array_merge($kab('Hulu Sungai Tengah', '013', '2025'), [
            'nik'              => '6308011507940013',
            'nomor_anggota'    => 'KBPB-HST-0003',
            'jenis_anggota'    => 'kelompok_tani',
            'kelompok_tani_id' => $ktHST->id,
            'nama_lengkap'     => 'Yudi Pratama',
            'tempat_lahir'     => 'Barabai',
            'tanggal_lahir'    => '1994-07-15',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Belum Kawin',
            'telepon'          => '081252230002',
            'alamat_ktp'       => 'Jl. Walangku RT 002 RW 001',
            'rt_ktp'           => '002', 'rw_ktp' => '001',
            'desa_ktp'         => 'Walangku',
            'kecamatan_ktp'    => 'Birayang',
            'kode_pos_ktp'     => '71313',
            'no_rekening'      => '01200300003',
            'nama_bank'        => 'BNI',
        ]));

        // ── Banjar – Petani Mandiri ───────────────────────────────
        $a14 = Anggota::create(array_merge($kab('Banjar', '014'), [
            'nik'              => '6303011208820014',
            'nomor_anggota'    => 'KBPB-BANJAR-0001',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'Muhammad Noor',
            'tempat_lahir'     => 'Martapura',
            'tanggal_lahir'    => '1982-08-12',
            'jenis_kelamin'    => 'L',
            'status_perkawinan'=> 'Kawin',
            'telepon'          => '085254001001',
            'alamat_ktp'       => 'Jl. Pemakuan RT 001 RW 001',
            'rt_ktp'           => '001', 'rw_ktp' => '001',
            'desa_ktp'         => 'Pemakuan',
            'kecamatan_ktp'    => 'Sungai Tabuk',
            'kode_pos_ktp'     => '70691',
            'no_rekening'      => '01200400001',
            'nama_bank'        => 'BNI',
        ]));

        $a15 = Anggota::create(array_merge($kab('Banjar', '015', '2025'), [
            'nik'              => '6303014506950015',
            'nomor_anggota'    => 'KBPB-BANJAR-0002',
            'jenis_anggota'    => 'personal',
            'nama_lengkap'     => 'Rahmawati',
            'tempat_lahir'     => 'Martapura',
            'tanggal_lahir'    => '1995-06-05',
            'jenis_kelamin'    => 'P',
            'status_perkawinan'=> 'Belum Kawin',
            'telepon'          => '085254001002',
            'alamat_ktp'       => 'Jl. Karang Intan RT 003 RW 001',
            'rt_ktp'           => '003', 'rw_ktp' => '001',
            'desa_ktp'         => 'Karang Intan',
            'kecamatan_ktp'    => 'Karang Intan',
            'kode_pos_ktp'     => '70662',
            'no_rekening'      => '01200400002',
            'nama_bank'        => 'BRI',
            'status'           => 'pending',
        ]));

        // ── User Petani ────────────────────────────────────────────
        $userPetaniList = [
            [$a1, 'petani.ahmad@kbpb.id', 'H. Ahmad Syarifudin'],
            [$a4, 'petani.fauzi@kbpb.id', 'Ahmad Fauzi (KT Rantau)'],
            [$a7, 'petani.bahrudin@kbpb.id', 'H. Bahrudin Noor'],
            [$a9, 'petani.sholeh@kbpb.id', 'M. Sholeh (KT HSS)'],
            [$a11, 'petani.sugianto@kbpb.id', 'Sugianto'],
            [$a14, 'petani.mnoor@kbpb.id', 'Muhammad Noor'],
        ];

        foreach ($userPetaniList as [$anggota, $email, $name]) {
            User::create([
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make('kbpb1234'),
                'role'       => 'petani',
                'aktif'      => true,
                'anggota_id' => $anggota->id,
            ]);
        }

        // ── Lahan – Petani Mandiri Tapin ───────────────────────────
        $l1 = Lahan::create([
            'anggota_id' => $a1->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Sungai Pinang I',
            'luas_lahan' => 2.0, 'satuan_luas' => 'ha',
            'desa_nama' => 'Sungai Pinang', 'kecamatan_nama' => 'Rantau', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Area perbukitan desa Sungai Pinang, akses jalan usaha tani',
            'latitude' => -2.9180, 'longitude' => 115.1750,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        $l2 = Lahan::create([
            'anggota_id' => $a1->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Sungai Pinang II',
            'luas_lahan' => 0.75, 'satuan_luas' => 'ha',
            'desa_nama' => 'Sungai Pinang', 'kecamatan_nama' => 'Rantau', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Ladang sebelah barat desa',
            'latitude' => -2.9145, 'longitude' => 115.1720,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'cukup subur', 'aktif' => true,
        ]);

        $l3 = Lahan::create([
            'anggota_id' => $a2->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Kupang Timur',
            'luas_lahan' => 1.5, 'satuan_luas' => 'ha',
            'desa_nama' => 'Kupang', 'kecamatan_nama' => 'Tapin Selatan', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan sewa dekat sungai',
            'latitude' => -2.9850, 'longitude' => 115.1050,
            'status_kepemilikan' => 'sewa', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        $l4 = Lahan::create([
            'anggota_id' => $a3->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Binuang Utara',
            'luas_lahan' => 2.5, 'satuan_luas' => 'ha',
            'desa_nama' => 'Binuang', 'kecamatan_nama' => 'Binuang', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan milik sendiri, dekat jalan Trans KM 24',
            'latitude' => -3.0280, 'longitude' => 115.2270,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        // ── Lahan – Kelompok Tani Tapin ─────────────────────────────
        $l5 = Lahan::create([
            'anggota_id' => $a4->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan KT Rantau – Blok A',
            'luas_lahan' => 1.8, 'satuan_luas' => 'ha',
            'desa_nama' => 'Sungai Pinang', 'kecamatan_nama' => 'Rantau', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Blok A kelompok tani Rantau Makmur',
            'latitude' => -2.9210, 'longitude' => 115.1790,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        $l6 = Lahan::create([
            'anggota_id' => $a5->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan KT Rantau – Blok B',
            'luas_lahan' => 1.2, 'satuan_luas' => 'ha',
            'desa_nama' => 'Baringin', 'kecamatan_nama' => 'Rantau', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Blok B kelompok tani',
            'latitude' => -2.9055, 'longitude' => 115.1680,
            'status_kepemilikan' => 'sewa', 'kondisi_tanah' => 'cukup subur', 'aktif' => true,
        ]);

        $l7 = Lahan::create([
            'anggota_id' => $a6->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan KT Rantau – Blok C',
            'luas_lahan' => 0.9, 'satuan_luas' => 'ha',
            'desa_nama' => 'Sungai Pinang', 'kecamatan_nama' => 'Rantau', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Blok C kelompok tani – anggota muda',
            'latitude' => -2.9230, 'longitude' => 115.1820,
            'status_kepemilikan' => 'pinjam', 'kondisi_tanah' => 'cukup subur', 'aktif' => true,
        ]);

        // ── Lahan – BUMDes Tapin (lahan desa) ──────────────────────
        $l8 = Lahan::create([
            'bumdes_id' => $bumdesTapin->id, 'pemilik_type' => 'bumdes', 'anggota_id' => null,
            'nama_lahan' => 'Lahan Desa Rantau Kiwa – Blok 1',
            'luas_lahan' => 3.5, 'satuan_luas' => 'ha',
            'desa_nama' => 'Rantau Kiwa', 'kecamatan_nama' => 'Rantau', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan kas desa Rantau Kiwa, dikelola BUMDes',
            'latitude' => -2.9320, 'longitude' => 115.1880,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        $l9 = Lahan::create([
            'bumdes_id' => $bumdesTapin->id, 'pemilik_type' => 'bumdes', 'anggota_id' => null,
            'nama_lahan' => 'Lahan Desa Rantau Kiwa – Blok 2',
            'luas_lahan' => 2.0, 'satuan_luas' => 'ha',
            'desa_nama' => 'Rantau Kiwa', 'kecamatan_nama' => 'Rantau', 'kabupaten_nama' => 'Tapin', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Blok 2 lahan desa, naungan sengon dan jati',
            'latitude' => -2.9350, 'longitude' => 115.1920,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        // ── Lahan – HSS ─────────────────────────────────────────────
        $l10 = Lahan::create([
            'anggota_id' => $a7->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Gambah Dalam',
            'luas_lahan' => 1.8, 'satuan_luas' => 'ha',
            'desa_nama' => 'Gambah Dalam', 'kecamatan_nama' => 'Kandangan', 'kabupaten_nama' => 'Hulu Sungai Selatan', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan tumpang sari, bagian barat desa',
            'latitude' => -2.7890, 'longitude' => 115.2620,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        $l11 = Lahan::create([
            'anggota_id' => $a8->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Tibung Raya',
            'luas_lahan' => 1.2, 'satuan_luas' => 'ha',
            'desa_nama' => 'Tibung Raya', 'kecamatan_nama' => 'Kandangan', 'kabupaten_nama' => 'Hulu Sungai Selatan', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan sewa dekat jalan utama Kandangan',
            'latitude' => -2.7920, 'longitude' => 115.2680,
            'status_kepemilikan' => 'sewa', 'kondisi_tanah' => 'cukup subur', 'aktif' => true,
        ]);

        $l12 = Lahan::create([
            'anggota_id' => $a9->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan KT HSS – Ketua',
            'luas_lahan' => 1.5, 'satuan_luas' => 'ha',
            'desa_nama' => 'Tibung Raya', 'kecamatan_nama' => 'Kandangan', 'kabupaten_nama' => 'Hulu Sungai Selatan', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan ketua kelompok tani HSS',
            'latitude' => -2.7855, 'longitude' => 115.2590,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        // Lahan BUMDes HSS
        $l13 = Lahan::create([
            'bumdes_id' => $bumdesHSS->id, 'pemilik_type' => 'bumdes', 'anggota_id' => null,
            'nama_lahan' => 'Lahan Kas Desa Gambah Dalam',
            'luas_lahan' => 4.0, 'satuan_luas' => 'ha',
            'desa_nama' => 'Gambah Dalam', 'kecamatan_nama' => 'Kandangan', 'kabupaten_nama' => 'Hulu Sungai Selatan', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan kas desa, dikelola BUMDes Kandangan Makmur',
            'latitude' => -2.7830, 'longitude' => 115.2550,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        // ── Lahan – HST ─────────────────────────────────────────────
        $l14 = Lahan::create([
            'anggota_id' => $a11->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Barabai Darat',
            'luas_lahan' => 1.2, 'satuan_luas' => 'ha',
            'desa_nama' => 'Barabai Darat', 'kecamatan_nama' => 'Barabai', 'kabupaten_nama' => 'Hulu Sungai Tengah', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan pribadi, akses jalan kecamatan',
            'latitude' => -2.5890, 'longitude' => 115.4030,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        $l15 = Lahan::create([
            'anggota_id' => $a12->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan KT HST – Barabai Utara',
            'luas_lahan' => 1.5, 'satuan_luas' => 'ha',
            'desa_nama' => 'Barabai Utara', 'kecamatan_nama' => 'Barabai', 'kabupaten_nama' => 'Hulu Sungai Tengah', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan kelompok tani blok utama',
            'latitude' => -2.5820, 'longitude' => 115.4010,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        $l16 = Lahan::create([
            'anggota_id' => $a13->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan KT HST – Walangku',
            'luas_lahan' => 0.8, 'satuan_luas' => 'ha',
            'desa_nama' => 'Walangku', 'kecamatan_nama' => 'Birayang', 'kabupaten_nama' => 'Hulu Sungai Tengah', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan muda anggota, baru dikerjakan',
            'latitude' => -2.6150, 'longitude' => 115.4340,
            'status_kepemilikan' => 'sewa', 'kondisi_tanah' => 'cukup subur', 'aktif' => true,
        ]);

        // Lahan BUMDes HST
        $l17 = Lahan::create([
            'bumdes_id' => $bumdesHST->id, 'pemilik_type' => 'bumdes', 'anggota_id' => null,
            'nama_lahan' => 'Lahan Kas Desa Barabai Darat',
            'luas_lahan' => 5.0, 'satuan_luas' => 'ha',
            'desa_nama' => 'Barabai Darat', 'kecamatan_nama' => 'Barabai', 'kabupaten_nama' => 'Hulu Sungai Tengah', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan kas desa, dikelola BUMDes Barabai Sejahtera',
            'latitude' => -2.5950, 'longitude' => 115.4080,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        // ── Lahan – Banjar ──────────────────────────────────────────
        $l18 = Lahan::create([
            'anggota_id' => $a14->id, 'pemilik_type' => 'petani',
            'nama_lahan' => 'Lahan Porang Pemakuan',
            'luas_lahan' => 1.3, 'satuan_luas' => 'ha',
            'desa_nama' => 'Pemakuan', 'kecamatan_nama' => 'Sungai Tabuk', 'kabupaten_nama' => 'Banjar', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan di pinggir sungai Martapura',
            'latitude' => -3.4010, 'longitude' => 114.8890,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'cukup subur', 'aktif' => true,
        ]);

        // Lahan BUMDes Banjar
        $l19 = Lahan::create([
            'bumdes_id' => $bumdesBanjar->id, 'pemilik_type' => 'bumdes', 'anggota_id' => null,
            'nama_lahan' => 'Lahan Kas Desa Pemakuan',
            'luas_lahan' => 3.2, 'satuan_luas' => 'ha',
            'desa_nama' => 'Pemakuan', 'kecamatan_nama' => 'Sungai Tabuk', 'kabupaten_nama' => 'Banjar', 'provinsi_nama' => 'Kalimantan Selatan',
            'alamat_lahan' => 'Lahan desa, dikelola BUMDes Sungai Tabuk Berkah',
            'latitude' => -3.3980, 'longitude' => 114.8920,
            'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur', 'aktif' => true,
        ]);

        // ── Tanaman ─────────────────────────────────────────────────
        // Helper untuk buat tanaman + panen sekaligus
        $buatTanaman = function (
            Lahan $lahan, ?Anggota $anggota, string $tglTanam, string $status,
            int $jarakX = 100, int $jarakY = 100,
            ?float $beratPanen = null, ?float $hargaPanen = null
        ) {
            $tgl = Carbon::parse($tglTanam);
            $estimasi = (clone $tgl)->addMonths(20);
            $estimasiBatang = Tanaman::hitungEstimasiBatang($lahan->luas_lahan, $lahan->satuan_luas, $jarakX, $jarakY);

            $tanamanData = [
                'lahan_id'          => $lahan->id,
                'anggota_id'        => $anggota?->id,
                'sumber_bibit'      => 'katak/bulbil',
                'jumlah_bibit'      => (int) ($estimasiBatang * 1.05),
                'jarak_tanam_x_cm'  => $jarakX,
                'jarak_tanam_y_cm'  => $jarakY,
                'estimasi_batang'   => $estimasiBatang,
                'tanggal_tanam'     => $tgl->toDateString(),
                'estimasi_panen'    => $estimasi->toDateString(),
                'status'            => $status,
                'pupuk_digunakan'   => 'Kompos, dolomit dan NPK Mutiara',
                'pestisida_digunakan'=> 'Organik nabati – PGPR',
            ];

            if ($status === 'panen' && $beratPanen) {
                $tglPanen = (clone $tgl)->addMonths(20)->addDays(rand(5, 25));
                $tanamanData['tanggal_panen_aktual'] = $tglPanen->toDateString();
                $tanamanData['berat_panen_kg']        = $beratPanen;
                $tanamanData['harga_per_kg_panen']    = $hargaPanen ?? 7500;
                $tanamanData['total_nilai_panen']     = $beratPanen * ($hargaPanen ?? 7500);
                $tanamanData['konfirmasi_panen_at']   = $tglPanen->toDateTimeString();
                $tanamanData['konfirmasi_panen_user_id'] = 1;
            }

            if (in_array($status, ['tumbuh', 'siap_panen', 'panen', 'tunda'])) {
                $tanamanData['konfirmasi_tanam_at']      = (clone $tgl)->addDays(30)->toDateTimeString();
                $tanamanData['konfirmasi_tanam_user_id'] = $anggota ? ($anggota->id % 6) + 3 : 1;
            }

            if ($status === 'gagal') {
                $tanamanData['gagal_alasan'] = 'Genangan air berkepanjangan saat musim hujan';
            }

            if ($status === 'tunda') {
                $tanamanData['tunda_tanggal_baru'] = (clone $tgl)->addMonths(22)->toDateString();
                $tanamanData['tunda_alasan'] = 'Harga pasar sedang turun, menunggu harga naik';
            }

            return Tanaman::create($tanamanData);
        };

        // Tapin – Lahan Petani
        $t1  = $buatTanaman($l1, $a1, '2023-03-01', 'panen', 100, 100, 1600.0, 5000);   // panen lama
        $t2  = $buatTanaman($l1, $a1, '2025-02-01', 'tumbuh');                           // tanam baru
        $t3  = $buatTanaman($l2, $a1, '2024-10-15', 'tumbuh');
        $t4  = $buatTanaman($l3, $a2, '2023-01-20', 'panen', 100, 100, 1125.0, 5000);   // panen lama
        $t5  = $buatTanaman($l3, $a2, '2025-01-05', 'siap_panen');
        $t6  = $buatTanaman($l4, $a3, '2023-05-10', 'panen', 100, 100, 1875.0, 6000);
        $t7  = $buatTanaman($l4, $a3, '2025-03-20', 'tanam');

        // Tapin – Kelompok Tani
        $t8  = $buatTanaman($l5, $a4, '2023-02-15', 'panen', 100, 100, 1440.0, 5000);
        $t9  = $buatTanaman($l5, $a4, '2025-01-10', 'tumbuh');
        $t10 = $buatTanaman($l6, $a5, '2024-11-01', 'tumbuh');
        $t11 = $buatTanaman($l7, $a6, '2025-04-01', 'persiapan');

        // Tapin – Lahan BUMDes
        $t12 = $buatTanaman($l8, null, '2023-04-01', 'panen', 100, 100, 2800.0, 6000);
        $t13 = $buatTanaman($l8, null, '2025-02-15', 'tumbuh');
        $t14 = $buatTanaman($l9, null, '2024-12-01', 'tanam');

        // HSS – Lahan Petani
        $t15 = $buatTanaman($l10, $a7, '2023-03-05', 'panen', 100, 100, 1440.0, 6000);
        $t16 = $buatTanaman($l10, $a7, '2025-01-20', 'tumbuh');
        $t17 = $buatTanaman($l11, $a8, '2024-08-10', 'gagal');
        $t18 = $buatTanaman($l11, $a8, '2025-03-15', 'tanam');
        $t19 = $buatTanaman($l12, $a9, '2024-10-01', 'tumbuh');

        // HSS – BUMDes
        $t20 = $buatTanaman($l13, null, '2023-06-01', 'panen', 100, 100, 3200.0, 7500);
        $t21 = $buatTanaman($l13, null, '2025-03-01', 'tanam');

        // HST – Lahan Petani
        $t22 = $buatTanaman($l14, $a11, '2023-04-15', 'panen', 100, 100, 960.0, 6000);
        $t23 = $buatTanaman($l14, $a11, '2025-02-10', 'tumbuh');
        $t24 = $buatTanaman($l15, $a12, '2025-01-15', 'tumbuh');
        $t25 = $buatTanaman($l16, $a13, '2025-04-01', 'persiapan');

        // HST – BUMDes
        $t26 = $buatTanaman($l17, null, '2023-07-01', 'panen', 100, 100, 4000.0, 7500);
        $t27 = $buatTanaman($l17, null, '2025-03-15', 'tumbuh');

        // Banjar
        $t28 = $buatTanaman($l18, $a14, '2025-02-20', 'tunda');
        $t29 = $buatTanaman($l19, null, '2025-01-10', 'tanam');

        // ── Panen (data panen yang sudah selesai) ──────────────────
        $panenList = [
            [$t1,  '2024-11-15', $l1,  $a1,  1600.0, 5000],
            [$t4,  '2024-09-20', $l3,  $a2,  1125.0, 5000],
            [$t6,  '2025-01-10', $l4,  $a3,  1875.0, 6000],
            [$t8,  '2024-10-15', $l5,  $a4,  1440.0, 5000],
            [$t12, '2025-02-01', $l8,  null, 2800.0, 6000],
            [$t15, '2024-11-05', $l10, $a7,  1440.0, 6000],
            [$t20, '2025-02-20', $l13, null, 3200.0, 7500],
            [$t22, '2025-02-14', $l14, $a11,  960.0, 6000],
            [$t26, '2025-03-01', $l17, null, 4000.0, 7500],
        ];

        foreach ($panenList as [$tanaman, $tglPanen, $lahan, $anggota, $berat, $harga]) {
            Panen::create([
                'tanaman_id'    => $tanaman->id,
                'lahan_id'      => $lahan->id,
                'anggota_id'    => $anggota?->id,
                'tanggal_panen' => $tglPanen,
                'berat_panen_kg'=> $berat,
                'harga_per_kg'  => $harga,
                'total_nilai'   => $berat * $harga,
                'metode_jual'   => 'koperasi',
                'pembeli'       => 'Koperasi Barakat Pangan Banua',
                'status_jual'   => 'terjual',
                'catatan'       => 'Panen melalui koperasi KBPB',
            ]);
        }

        $this->command->info('✅ Data dummy Kalimantan Selatan berhasil dibuat!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Super Admin',    'superadmin@kbpb.id',  'kbpb1234'],
                ['Admin',          'admin@kbpb.id',       'kbpb1234'],
                ['Operator',       'operator@kbpb.id',    'kbpb1234'],
                ['PJ Tapin',       'pj.tapin@kbpb.id',   'kbpb1234'],
                ['PJ HSS',         'pj.hss@kbpb.id',     'kbpb1234'],
                ['PJ HST',         'pj.hst@kbpb.id',     'kbpb1234'],
                ['PJ Banjar',      'pj.banjar@kbpb.id',  'kbpb1234'],
                ['BUMDes Tapin',   'bumdes.tapin@kbpb.id','kbpb1234'],
                ['BUMDes HSS',     'bumdes.hss@kbpb.id', 'kbpb1234'],
                ['Petani Ahmad',   'petani.ahmad@kbpb.id','kbpb1234'],
                ['Petani Fauzi',   'petani.fauzi@kbpb.id','kbpb1234'],
                ['Petani Bahrudin','petani.bahrudin@kbpb.id','kbpb1234'],
                ['Petani Sholeh',  'petani.sholeh@kbpb.id','kbpb1234'],
                ['Petani Sugianto','petani.sugianto@kbpb.id','kbpb1234'],
                ['Petani M.Noor',  'petani.mnoor@kbpb.id','kbpb1234'],
            ]
        );
    }
}
