<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\Bumdes;
use App\Models\Koperasi;
use App\Models\Lahan;
use App\Models\Panen;
use App\Models\Tanaman;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TapinDummySeeder extends Seeder
{
    public function run(): void
    {
        $koperasi = Koperasi::firstOrCreate(
            ['nama' => 'Koperasi Tani Makmur Porang']
        );

        $bumdesList = [
            'tapin_maju' => Bumdes::updateOrCreate(
                ['nama' => 'BUMDes Tapin Maju Sejahtera'],
                [
                    'nomor_sk' => '140/BUMDES-TAPIN/2023',
                    'tanggal_sk' => '2023-06-15',
                    'alamat' => 'Jl. Brigjen H. Hasan Basri No. 12, Rantau',
                    'provinsi_nama' => 'Kalimantan Selatan',
                    'kabupaten_nama' => 'Tapin',
                    'kecamatan_nama' => 'Rantau',
                    'desa_nama' => 'Rangda Malingkung',
                    'direktur' => 'Syahrani',
                    'telepon' => '081251110001',
                    'email' => 'bumdes.tapin@porang.id',
                    'rekening_bank' => '1002003001',
                    'nama_bank' => 'Bank Kalsel',
                    'aktif' => true,
                ]
            ),
            'harapan_bersama' => Bumdes::updateOrCreate(
                ['nama' => 'BUMDes Harapan Bersama Tapin'],
                [
                    'nomor_sk' => '141/BUMDES-HB/2023',
                    'tanggal_sk' => '2023-08-02',
                    'alamat' => 'Jl. Trans Kalimantan KM 87, Binuang',
                    'provinsi_nama' => 'Kalimantan Selatan',
                    'kabupaten_nama' => 'Tapin',
                    'kecamatan_nama' => 'Binuang',
                    'desa_nama' => 'Binuang',
                    'direktur' => 'Ramlah',
                    'telepon' => '081251110002',
                    'email' => 'harapan.bersama@porang.id',
                    'rekening_bank' => '1002003002',
                    'nama_bank' => 'Bank Kalsel',
                    'aktif' => true,
                ]
            ),
        ];

        $anggotaData = [
            ['nik' => '6305010101900001', 'nomor_anggota' => 'KTP-TAPIN-0001', 'nama_lengkap' => 'Ahmad Yani', 'tanggal_lahir' => '1990-01-01', 'jenis_kelamin' => 'L', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110101', 'alamat_ktp' => 'Jl. Porang Raya RT 01', 'rt_ktp' => '001', 'rw_ktp' => '002', 'desa_ktp' => 'Rangda Malingkung', 'kecamatan_ktp' => 'Rantau', 'kode_pos_ktp' => '71111', 'jenis_anggota' => 'personal', 'tanggal_daftar' => '2024-01-15', 'status' => 'aktif', 'no_rekening' => '70010001', 'nama_bank' => 'BRI'],
            ['nik' => '6305010202920002', 'nomor_anggota' => 'KTP-TAPIN-0002', 'nama_lengkap' => 'Siti Rahmah', 'tanggal_lahir' => '1992-02-02', 'jenis_kelamin' => 'P', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110102', 'alamat_ktp' => 'Jl. Melati Porang RT 02', 'rt_ktp' => '002', 'rw_ktp' => '001', 'desa_ktp' => 'Kupang', 'kecamatan_ktp' => 'Tapin Selatan', 'kode_pos_ktp' => '71112', 'jenis_anggota' => 'bumdes', 'bumdes_key' => 'tapin_maju', 'tanggal_daftar' => '2024-02-10', 'status' => 'aktif', 'no_rekening' => '70010002', 'nama_bank' => 'Bank Kalsel'],
            ['nik' => '6305010303880003', 'nomor_anggota' => 'KTP-TAPIN-0003', 'nama_lengkap' => 'Rudi Hartono', 'tanggal_lahir' => '1988-03-03', 'jenis_kelamin' => 'L', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110103', 'alamat_ktp' => 'Jl. Sawah Makmur RT 03', 'rt_ktp' => '003', 'rw_ktp' => '002', 'desa_ktp' => 'Binuang', 'kecamatan_ktp' => 'Binuang', 'kode_pos_ktp' => '71113', 'jenis_anggota' => 'personal', 'tanggal_daftar' => '2024-03-05', 'status' => 'aktif', 'no_rekening' => '70010003', 'nama_bank' => 'BNI'],
            ['nik' => '6305010404850004', 'nomor_anggota' => 'KTP-TAPIN-0004', 'nama_lengkap' => 'Mariam', 'tanggal_lahir' => '1985-04-04', 'jenis_kelamin' => 'P', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110104', 'alamat_ktp' => 'Jl. Kebun Sejahtera RT 04', 'rt_ktp' => '004', 'rw_ktp' => '001', 'desa_ktp' => 'Margasari Hilir', 'kecamatan_ktp' => 'Candi Laras Selatan', 'kode_pos_ktp' => '71114', 'jenis_anggota' => 'bumdes', 'bumdes_key' => 'tapin_maju', 'tanggal_daftar' => '2024-04-01', 'status' => 'pending', 'no_rekening' => '70010004', 'nama_bank' => 'Mandiri'],
            ['nik' => '6305010505910005', 'nomor_anggota' => 'KTP-TAPIN-0005', 'nama_lengkap' => 'Jamaluddin', 'tanggal_lahir' => '1991-05-05', 'jenis_kelamin' => 'L', 'status_perkawinan' => 'Belum Kawin', 'telepon' => '081251110105', 'alamat_ktp' => 'Jl. Tani Porang RT 05', 'rt_ktp' => '005', 'rw_ktp' => '003', 'desa_ktp' => 'Salam Babaris', 'kecamatan_ktp' => 'Salam Babaris', 'kode_pos_ktp' => '71115', 'jenis_anggota' => 'personal', 'tanggal_daftar' => '2024-05-20', 'status' => 'aktif', 'no_rekening' => '70010005', 'nama_bank' => 'BRI'],
            ['nik' => '6305010606870006', 'nomor_anggota' => 'KTP-TAPIN-0006', 'nama_lengkap' => 'Nurhayati', 'tanggal_lahir' => '1987-06-06', 'jenis_kelamin' => 'P', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110106', 'alamat_ktp' => 'Jl. Poros Lokpaikat RT 01', 'rt_ktp' => '001', 'rw_ktp' => '001', 'desa_ktp' => 'Lokpaikat', 'kecamatan_ktp' => 'Lokpaikat', 'kode_pos_ktp' => '71116', 'jenis_anggota' => 'bumdes', 'bumdes_key' => 'harapan_bersama', 'tanggal_daftar' => '2024-06-11', 'status' => 'aktif', 'no_rekening' => '70010006', 'nama_bank' => 'Bank Kalsel'],
            ['nik' => '6305010707830007', 'nomor_anggota' => 'KTP-TAPIN-0007', 'nama_lengkap' => 'Rahman Baseri', 'tanggal_lahir' => '1983-07-07', 'jenis_kelamin' => 'L', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110107', 'alamat_ktp' => 'Jl. Bungur Baru RT 02', 'rt_ktp' => '002', 'rw_ktp' => '002', 'desa_ktp' => 'Bungur Baru', 'kecamatan_ktp' => 'Bungur', 'kode_pos_ktp' => '71117', 'jenis_anggota' => 'personal', 'tanggal_daftar' => '2024-06-18', 'status' => 'aktif', 'no_rekening' => '70010007', 'nama_bank' => 'BRI'],
            ['nik' => '6305010808890008', 'nomor_anggota' => 'KTP-TAPIN-0008', 'nama_lengkap' => 'Lisdawati', 'tanggal_lahir' => '1989-08-08', 'jenis_kelamin' => 'P', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110108', 'alamat_ktp' => 'Jl. Pematang Karangan RT 03', 'rt_ktp' => '003', 'rw_ktp' => '002', 'desa_ktp' => 'Pematang Karangan Hulu', 'kecamatan_ktp' => 'Tapin Tengah', 'kode_pos_ktp' => '71118', 'jenis_anggota' => 'bumdes', 'bumdes_key' => 'tapin_maju', 'tanggal_daftar' => '2024-07-09', 'status' => 'aktif', 'no_rekening' => '70010008', 'nama_bank' => 'BNI'],
            ['nik' => '6305010909900009', 'nomor_anggota' => 'KTP-TAPIN-0009', 'nama_lengkap' => 'Hendra Saputra', 'tanggal_lahir' => '1990-09-09', 'jenis_kelamin' => 'L', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110109', 'alamat_ktp' => 'Jl. Candi Laras Utara RT 01', 'rt_ktp' => '001', 'rw_ktp' => '003', 'desa_ktp' => 'Margasari Ulu', 'kecamatan_ktp' => 'Candi Laras Utara', 'kode_pos_ktp' => '71119', 'jenis_anggota' => 'personal', 'tanggal_daftar' => '2024-07-22', 'status' => 'aktif', 'no_rekening' => '70010009', 'nama_bank' => 'Mandiri'],
            ['nik' => '6305011010910010', 'nomor_anggota' => 'KTP-TAPIN-0010', 'nama_lengkap' => 'Yuliana', 'tanggal_lahir' => '1991-10-10', 'jenis_kelamin' => 'P', 'status_perkawinan' => 'Belum Kawin', 'telepon' => '081251110110', 'alamat_ktp' => 'Jl. Hatungun Sentosa RT 02', 'rt_ktp' => '002', 'rw_ktp' => '004', 'desa_ktp' => 'Hatungun', 'kecamatan_ktp' => 'Hatungun', 'kode_pos_ktp' => '71120', 'jenis_anggota' => 'bumdes', 'bumdes_key' => 'harapan_bersama', 'tanggal_daftar' => '2024-08-05', 'status' => 'aktif', 'no_rekening' => '70010010', 'nama_bank' => 'Bank Kalsel'],
            ['nik' => '6305011111920011', 'nomor_anggota' => 'KTP-TAPIN-0011', 'nama_lengkap' => 'Arifin Noor', 'tanggal_lahir' => '1992-11-11', 'jenis_kelamin' => 'L', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110111', 'alamat_ktp' => 'Jl. Piani Subur RT 03', 'rt_ktp' => '003', 'rw_ktp' => '001', 'desa_ktp' => 'Piani', 'kecamatan_ktp' => 'Piani', 'kode_pos_ktp' => '71121', 'jenis_anggota' => 'personal', 'tanggal_daftar' => '2024-08-18', 'status' => 'aktif', 'no_rekening' => '70010011', 'nama_bank' => 'BRI'],
            ['nik' => '6305011212930012', 'nomor_anggota' => 'KTP-TAPIN-0012', 'nama_lengkap' => 'Dewi Kartika', 'tanggal_lahir' => '1993-12-12', 'jenis_kelamin' => 'P', 'status_perkawinan' => 'Kawin', 'telepon' => '081251110112', 'alamat_ktp' => 'Jl. Bakarangan RT 04', 'rt_ktp' => '004', 'rw_ktp' => '002', 'desa_ktp' => 'Bakarangan', 'kecamatan_ktp' => 'Bakarangan', 'kode_pos_ktp' => '71122', 'jenis_anggota' => 'bumdes', 'bumdes_key' => 'harapan_bersama', 'tanggal_daftar' => '2024-09-03', 'status' => 'aktif', 'no_rekening' => '70010012', 'nama_bank' => 'BNI'],
        ];

        $anggotaMap = [];

        foreach ($anggotaData as $index => $item) {
            $anggota = Anggota::updateOrCreate(
                ['nik' => $item['nik']],
                [
                    'nomor_anggota' => $item['nomor_anggota'],
                    'jenis_anggota' => $item['jenis_anggota'],
                    'bumdes_id' => isset($item['bumdes_key']) ? $bumdesList[$item['bumdes_key']]->id : null,
                    'nama_lengkap' => $item['nama_lengkap'],
                    'tempat_lahir' => 'Tapin',
                    'tanggal_lahir' => $item['tanggal_lahir'],
                    'jenis_kelamin' => $item['jenis_kelamin'],
                    'golongan_darah' => '-',
                    'agama' => 'Islam',
                    'status_perkawinan' => $item['status_perkawinan'],
                    'pendidikan' => 'SMA/SMK',
                    'pekerjaan_ktp' => 'Petani',
                    'kewarganegaraan' => 'WNI',
                    'alamat_ktp' => $item['alamat_ktp'],
                    'rt_ktp' => $item['rt_ktp'],
                    'rw_ktp' => $item['rw_ktp'],
                    'desa_ktp' => $item['desa_ktp'],
                    'kecamatan_ktp' => $item['kecamatan_ktp'],
                    'kabupaten_ktp' => 'Tapin',
                    'provinsi_ktp' => 'Kalimantan Selatan',
                    'kode_pos_ktp' => $item['kode_pos_ktp'],
                    'telepon' => $item['telepon'],
                    'no_rekening' => $item['no_rekening'],
                    'nama_bank' => $item['nama_bank'],
                    'koperasi_id' => $koperasi->id,
                    'tanggal_daftar' => $item['tanggal_daftar'],
                    'status' => $item['status'],
                    'catatan' => 'Data dummy petani porang Kabupaten Tapin',
                ]
            );

            $anggotaMap['a' . ($index + 1)] = $anggota;
        }

        $lahanData = [
            ['anggota_key' => 'a1', 'nama_lahan' => 'Lahan Porang Rantau Timur', 'luas_lahan' => 1.8, 'desa_nama' => 'Rangda Malingkung', 'kecamatan_nama' => 'Rantau', 'latitude' => -2.92451234, 'longitude' => 115.17384567, 'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur'],
            ['anggota_key' => 'a1', 'nama_lahan' => 'Lahan Porang Rantau Barat', 'luas_lahan' => 0.85, 'desa_nama' => 'Rangda Malingkung', 'kecamatan_nama' => 'Rantau', 'latitude' => -2.91891234, 'longitude' => 115.16824567, 'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'cukup subur'],
            ['anggota_key' => 'a2', 'nama_lahan' => 'Lahan Porang Kupang Utara', 'luas_lahan' => 1.2, 'desa_nama' => 'Kupang', 'kecamatan_nama' => 'Tapin Selatan', 'latitude' => -2.99043112, 'longitude' => 115.10561234, 'status_kepemilikan' => 'sewa', 'kondisi_tanah' => 'cukup subur'],
            ['anggota_key' => 'a2', 'nama_lahan' => 'Lahan Porang Kupang Tengah', 'luas_lahan' => 1.05, 'desa_nama' => 'Kupang', 'kecamatan_nama' => 'Tapin Selatan', 'latitude' => -2.98673112, 'longitude' => 115.11121234, 'status_kepemilikan' => 'pinjam', 'kondisi_tanah' => 'subur'],
            ['anggota_key' => 'a3', 'nama_lahan' => 'Lahan Porang Binuang 1', 'luas_lahan' => 2.4, 'desa_nama' => 'Binuang', 'kecamatan_nama' => 'Binuang', 'latitude' => -3.02784567, 'longitude' => 115.22894321, 'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur'],
            ['anggota_key' => 'a4', 'nama_lahan' => 'Lahan Porang Candi Laras', 'luas_lahan' => 0.9, 'desa_nama' => 'Margasari Hilir', 'kecamatan_nama' => 'Candi Laras Selatan', 'latitude' => -2.78541234, 'longitude' => 115.01984567, 'status_kepemilikan' => 'pinjam', 'kondisi_tanah' => 'cukup subur'],
            ['anggota_key' => 'a5', 'nama_lahan' => 'Lahan Porang Salam Babaris', 'luas_lahan' => 1.5, 'desa_nama' => 'Salam Babaris', 'kecamatan_nama' => 'Salam Babaris', 'latitude' => -2.86715432, 'longitude' => 115.09876543, 'status_kepemilikan' => 'gadai', 'kondisi_tanah' => 'kurang subur'],
            ['anggota_key' => 'a6', 'nama_lahan' => 'Lahan Porang Lokpaikat', 'luas_lahan' => 1.35, 'desa_nama' => 'Lokpaikat', 'kecamatan_nama' => 'Lokpaikat', 'latitude' => -2.87354112, 'longitude' => 115.24489231, 'status_kepemilikan' => 'sewa', 'kondisi_tanah' => 'subur'],
            ['anggota_key' => 'a7', 'nama_lahan' => 'Lahan Porang Bungur Baru', 'luas_lahan' => 1.1, 'desa_nama' => 'Bungur Baru', 'kecamatan_nama' => 'Bungur', 'latitude' => -2.93271541, 'longitude' => 115.28194532, 'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur'],
            ['anggota_key' => 'a8', 'nama_lahan' => 'Lahan Porang Tapin Tengah', 'luas_lahan' => 0.95, 'desa_nama' => 'Pematang Karangan Hulu', 'kecamatan_nama' => 'Tapin Tengah', 'latitude' => -2.94812345, 'longitude' => 115.14253412, 'status_kepemilikan' => 'pinjam', 'kondisi_tanah' => 'cukup subur'],
            ['anggota_key' => 'a9', 'nama_lahan' => 'Lahan Porang Margasari Ulu', 'luas_lahan' => 1.75, 'desa_nama' => 'Margasari Ulu', 'kecamatan_nama' => 'Candi Laras Utara', 'latitude' => -2.74235112, 'longitude' => 115.08753112, 'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur'],
            ['anggota_key' => 'a10', 'nama_lahan' => 'Lahan Porang Hatungun', 'luas_lahan' => 1.05, 'desa_nama' => 'Hatungun', 'kecamatan_nama' => 'Hatungun', 'latitude' => -2.90984567, 'longitude' => 115.33245678, 'status_kepemilikan' => 'sewa', 'kondisi_tanah' => 'cukup subur'],
            ['anggota_key' => 'a11', 'nama_lahan' => 'Lahan Porang Piani', 'luas_lahan' => 2.1, 'desa_nama' => 'Piani', 'kecamatan_nama' => 'Piani', 'latitude' => -2.74489123, 'longitude' => 115.38871234, 'status_kepemilikan' => 'milik sendiri', 'kondisi_tanah' => 'subur'],
            ['anggota_key' => 'a12', 'nama_lahan' => 'Lahan Porang Bakarangan', 'luas_lahan' => 0.88, 'desa_nama' => 'Bakarangan', 'kecamatan_nama' => 'Bakarangan', 'latitude' => -2.95761345, 'longitude' => 115.01284567, 'status_kepemilikan' => 'gadai', 'kondisi_tanah' => 'kurang subur'],
        ];

        $lahanList = [];

        foreach ($lahanData as $index => $item) {
            $anggota = $anggotaMap[$item['anggota_key']];

            $lahanList[] = Lahan::updateOrCreate(
                [
                    'anggota_id' => $anggota->id,
                    'nama_lahan' => $item['nama_lahan'],
                ],
                [
                    'luas_lahan' => $item['luas_lahan'],
                    'satuan_luas' => 'ha',
                    'desa_nama' => $item['desa_nama'],
                    'kecamatan_nama' => $item['kecamatan_nama'],
                    'kabupaten_nama' => 'Tapin',
                    'provinsi_nama' => 'Kalimantan Selatan',
                    'alamat_lahan' => 'Area pertanian porang ' . $item['desa_nama'] . ', Tapin',
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'status_kepemilikan' => $item['status_kepemilikan'],
                    'kondisi_tanah' => $item['kondisi_tanah'],
                    'aktif' => true,
                    'catatan' => 'Dummy lahan Tapin dengan pembeda personal dan BUMDes',
                ]
            );
        }

        $statusCycle = ['tumbuh', 'tanam', 'panen', 'persiapan', 'gagal', 'tumbuh', 'tanam', 'panen', 'tumbuh', 'persiapan', 'tanam', 'tumbuh', 'panen', 'gagal'];
        $tanamanList = [];

        foreach ($lahanList as $index => $lahan) {
            $tanggalTanam = Carbon::now()->subMonths(22 - ($index % 8))->startOfMonth()->addDays(4 + $index);
            $status = $statusCycle[$index] ?? 'tanam';

            $tanamanList[] = Tanaman::updateOrCreate(
                [
                    'lahan_id' => $lahan->id,
                    'tanggal_tanam' => $tanggalTanam->toDateString(),
                ],
                [
                    'anggota_id' => $lahan->anggota_id,
                    'varietas' => 'Amorphophallus muelleri',
                    'sumber_bibit' => $index % 3 === 0 ? 'umbi' : 'katak/bulbil',
                    'jumlah_bibit' => 1200 + ($index * 130),
                    'luas_tanam' => max(0.5, $lahan->luas_lahan - 0.15),
                    'jarak_tanam' => '100x100 cm',
                    'estimasi_panen' => (clone $tanggalTanam)->addMonths(20)->toDateString(),
                    'tanggal_panen_aktual' => $status === 'panen' ? (clone $tanggalTanam)->addMonths(20)->toDateString() : null,
                    'status' => $status,
                    'pupuk_digunakan' => $index % 2 === 0 ? 'Kompos dan NPK' : 'Kompos, dolomit, NPK',
                    'pestisida_digunakan' => $index % 4 === 0 ? 'Hayati ringan' : 'Organik nabati',
                    'kendala' => $status === 'gagal' ? 'Drainase lahan kurang baik saat hujan' : ($status === 'persiapan' ? 'Masih penataan guludan dan naungan' : null),
                    'catatan' => 'Dummy tanaman porang Tapin',
                ]
            );
        }

        $panenRecords = [
            ['tanaman_index' => 0, 'months_ago' => 11, 'berat' => 1320.5, 'kualitas' => 'Grade A', 'harga' => 7200, 'pembeli' => 'PT Porang Nusantara', 'metode' => 'koperasi', 'status_jual' => 'terjual'],
            ['tanaman_index' => 1, 'months_ago' => 8, 'berat' => 860.0, 'kualitas' => 'Grade B', 'harga' => 4900, 'pembeli' => 'UD Tani Makmur', 'metode' => 'pasar', 'status_jual' => 'terjual'],
            ['tanaman_index' => 2, 'months_ago' => 7, 'berat' => 940.3, 'kualitas' => 'Grade A', 'harga' => 7600, 'pembeli' => 'Koperasi Tapin', 'metode' => 'koperasi', 'status_jual' => 'terjual'],
            ['tanaman_index' => 4, 'months_ago' => 6, 'berat' => 1435.7, 'kualitas' => 'Grade A', 'harga' => 7800, 'pembeli' => 'PT Ekspor Umbi', 'metode' => 'ekspor', 'status_jual' => 'terjual'],
            ['tanaman_index' => 5, 'months_ago' => 5, 'berat' => 540.3, 'kualitas' => 'Grade C', 'harga' => 2400, 'pembeli' => 'Pedagang Lokal', 'metode' => 'tengkulak', 'status_jual' => 'terjual'],
            ['tanaman_index' => 6, 'months_ago' => 4, 'berat' => 990.2, 'kualitas' => 'Grade B', 'harga' => 5200, 'pembeli' => 'CV Umbi Jaya', 'metode' => 'langsung', 'status_jual' => 'sebagian'],
            ['tanaman_index' => 7, 'months_ago' => 3, 'berat' => 1210.4, 'kualitas' => 'Grade A', 'harga' => 7350, 'pembeli' => 'PT Porang Nusantara', 'metode' => 'koperasi', 'status_jual' => 'terjual'],
            ['tanaman_index' => 8, 'months_ago' => 2, 'berat' => 805.8, 'kualitas' => 'Grade B', 'harga' => 4650, 'pembeli' => 'Koperasi Tapin', 'metode' => 'koperasi', 'status_jual' => 'sebagian'],
            ['tanaman_index' => 10, 'months_ago' => 1, 'berat' => 1575.6, 'kualitas' => 'Grade A', 'harga' => 7950, 'pembeli' => 'PT Agro Kalimantan', 'metode' => 'ekspor', 'status_jual' => 'terjual'],
            ['tanaman_index' => 12, 'months_ago' => 1, 'berat' => 688.4, 'kualitas' => 'Grade C', 'harga' => 2600, 'pembeli' => 'Pedagang Desa', 'metode' => 'pasar', 'status_jual' => 'terjual'],
        ];

        foreach ($panenRecords as $item) {
            $tanaman = $tanamanList[$item['tanaman_index']];
            $tanggalPanen = Carbon::now()->subMonths($item['months_ago'])->day(10 + ($item['tanaman_index'] % 12));

            Panen::updateOrCreate(
                [
                    'tanaman_id' => $tanaman->id,
                    'tanggal_panen' => $tanggalPanen->toDateString(),
                ],
                [
                    'lahan_id' => $tanaman->lahan_id,
                    'anggota_id' => $tanaman->anggota_id,
                    'berat_panen_kg' => $item['berat'],
                    'kualitas' => $item['kualitas'],
                    'harga_per_kg' => $item['harga'],
                    'total_nilai' => $item['berat'] * $item['harga'],
                    'pembeli' => $item['pembeli'],
                    'metode_jual' => $item['metode'],
                    'status_jual' => $item['status_jual'],
                    'catatan' => 'Data dummy panen porang wilayah Tapin',
                ]
            );
        }
    }
}
