<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Lahan;
use App\Models\Tanaman;
use App\Models\Panen;
use App\Models\Koperasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $koperasi = Koperasi::first();

        // Statistik utama
        $stats = [
            'total_anggota'  => Anggota::where('status', 'aktif')->count(),
            'total_lahan'    => Lahan::where('aktif', true)->count(),
            'luas_total_ha'  => Lahan::where('aktif', true)->get()->sum('luas_hektar'),
            'total_panen_kg' => Panen::sum('berat_panen_kg'),
            'total_tanam'    => Tanaman::whereIn('status', ['tanam', 'tumbuh'])->count(),
            'nilai_panen'    => Panen::sum('total_nilai'),
            'pending'        => Anggota::where('status', 'pending')->count(),
        ];

        // Penyebaran anggota per kabupaten
        $sebaranKabupaten = Anggota::where('status', 'aktif')
            ->select('kabupaten_ktp', DB::raw('count(*) as total'))
            ->whereNotNull('kabupaten_ktp')
            ->groupBy('kabupaten_ktp')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Panen per bulan (12 bulan terakhir)
        $panenBulanan = Panen::select(
            DB::raw('MONTH(tanggal_panen) as bulan'),
            DB::raw('YEAR(tanggal_panen) as tahun'),
            DB::raw('SUM(berat_panen_kg) as total_kg'),
            DB::raw('SUM(total_nilai) as total_nilai')
        )
            ->where('tanggal_panen', '>=', now()->subMonths(12))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')->orderBy('bulan')
            ->get();

        // Status tanaman
        $statusTanaman = Tanaman::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Kualitas panen
        $kualitasPanen = Panen::select('kualitas', DB::raw('SUM(berat_panen_kg) as total_kg'))
            ->groupBy('kualitas')
            ->get();

        // Data lahan dengan koordinat untuk peta
        $lahanPeta = Lahan::with('anggota:id,nama_lengkap')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('aktif', true)
            ->select('id', 'nama_lahan', 'latitude', 'longitude', 'luas_lahan', 'satuan_luas', 'anggota_id', 'desa_nama', 'kabupaten_nama')
            ->get();

        // Anggota terbaru
        $anggotaTerbaru = Anggota::with('koperasi')
            ->latest()
            ->limit(5)
            ->get();

        // Panen terbaru
        $panenTerbaru = Panen::with(['anggota:id,nama_lengkap', 'lahan:id,nama_lahan'])
            ->latest('tanggal_panen')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'koperasi', 'stats', 'sebaranKabupaten',
            'panenBulanan', 'statusTanaman', 'kualitasPanen',
            'lahanPeta', 'anggotaTerbaru', 'panenTerbaru'
        ));
    }
}
