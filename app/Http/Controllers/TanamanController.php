<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\HargaPorang;
use App\Models\Lahan;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TanamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tanaman::with(['anggota:id,nama_lengkap', 'lahan:id,nama_lahan,bumdes_id,pemilik_type', 'lahan.bumdes:id,nama']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->whereHas('anggota', fn($q2) => $q2->where('nama_lengkap', 'like', "%$s%"))
                  ->orWhereHas('lahan', fn($q2) => $q2->where('nama_lahan', 'like', "%$s%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tanaman = $query->latest()->paginate(15)->withQueryString();
        return view('tanaman.index', compact('tanaman'));
    }

    public function create(Request $request)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);

        $lahan = collect();
        if ($request->filled('anggota_id')) {
            $lahan = Lahan::where('anggota_id', $request->anggota_id)
                ->where('aktif', true)
                ->get(['id', 'nama_lahan', 'luas_lahan', 'satuan_luas']);
        } elseif ($request->filled('lahan_id')) {
            // BUMDes lahan passed directly
            $lahan = Lahan::where('id', $request->lahan_id)->where('aktif', true)
                ->get(['id', 'nama_lahan', 'luas_lahan', 'satuan_luas']);
        }

        return view('tanaman.create', compact('anggota', 'lahan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if (empty($data['estimasi_panen']) && !empty($data['tanggal_tanam'])) {
            $data['estimasi_panen'] = Tanaman::hitungEstimasiPanen($data['tanggal_tanam']);
        }

        // Auto-calculate stem count from lahan
        $lahan = Lahan::find($data['lahan_id']);
        if ($lahan) {
            $data['estimasi_batang'] = Tanaman::hitungEstimasiBatang(
                $lahan->luas_lahan,
                $lahan->satuan_luas,
                $data['jarak_tanam_x_cm'] ?? 100,
                $data['jarak_tanam_y_cm'] ?? 100,
            );
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('tanaman', 'public');
        }

        $tanaman = Tanaman::create($data);

        return redirect()->route('tanaman.show', $tanaman)
            ->with('success', 'Data penanaman berhasil disimpan.');
    }

    public function show(Tanaman $tanaman)
    {
        $tanaman->load(['anggota', 'lahan.bumdes', 'panen' => fn($q) => $q->latest()]);
        $hargaAktif = HargaPorang::hargaAktif();
        return view('tanaman.show', compact('tanaman', 'hargaAktif'));
    }

    public function edit(Tanaman $tanaman)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);

        $lahan = Lahan::where('anggota_id', $tanaman->anggota_id)
            ->where('aktif', true)
            ->get(['id', 'nama_lahan', 'luas_lahan', 'satuan_luas']);

        return view('tanaman.edit', compact('tanaman', 'anggota', 'lahan'));
    }

    public function update(Request $request, Tanaman $tanaman)
    {
        $data = $request->validate($this->rules());

        // Recalculate stems if spacing changed
        $lahan = Lahan::find($data['lahan_id']);
        if ($lahan) {
            $data['estimasi_batang'] = Tanaman::hitungEstimasiBatang(
                $lahan->luas_lahan,
                $lahan->satuan_luas,
                $data['jarak_tanam_x_cm'] ?? 100,
                $data['jarak_tanam_y_cm'] ?? 100,
            );
        }

        if ($request->hasFile('foto')) {
            if ($tanaman->foto) Storage::disk('public')->delete($tanaman->foto);
            $data['foto'] = $request->file('foto')->store('tanaman', 'public');
        }

        $tanaman->update($data);

        return redirect()->route('tanaman.show', $tanaman)
            ->with('success', 'Data penanaman berhasil diperbarui.');
    }

    public function destroy(Tanaman $tanaman)
    {
        if ($tanaman->foto) Storage::disk('public')->delete($tanaman->foto);
        $tanaman->delete();
        return redirect()->route('tanaman.index')->with('success', 'Data penanaman berhasil dihapus.');
    }

    // ── Petani lifecycle actions ───────────────────────────────────

    /** Petani mengklik: Konfirmasi sudah tanam */
    public function konfirmasiTanam(Request $request, Tanaman $tanaman)
    {
        abort_if($tanaman->sudahKonfirmasiTanam(), 403, 'Sudah dikonfirmasi.');

        $tanaman->update([
            'status'                   => 'tumbuh',
            'konfirmasi_tanam_at'      => now(),
            'konfirmasi_tanam_user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Konfirmasi tanam berhasil dicatat. Status berubah ke Tumbuh.');
    }

    /** Petani mengklik: Konfirmasi panen */
    public function konfirmasiPanen(Request $request, Tanaman $tanaman)
    {
        abort_if($tanaman->sudahPanen(), 403, 'Sudah panen.');

        if (!$tanaman->bisaPanen()) {
            return back()->with('error',
                'Belum bisa konfirmasi panen. Tanaman baru berumur ' . $tanaman->umur_saat_ini .
                ' bulan. Minimal 12 bulan setelah tanam.');
        }

        $data = $request->validate([
            'berat_panen_kg' => 'required|numeric|min:0.1',
            'catatan'        => 'nullable|string|max:500',
        ]);

        $harga = HargaPorang::hargaAktif();

        $tanaman->update([
            'status'                   => 'panen',
            'konfirmasi_panen_at'      => now(),
            'konfirmasi_panen_user_id' => auth()->id(),
            'tanggal_panen_aktual'     => today(),
            'berat_panen_kg'           => $data['berat_panen_kg'],
            'harga_per_kg_panen'       => $harga?->harga_per_kg,
            'total_nilai_panen'        => $harga ? $harga->harga_per_kg * $data['berat_panen_kg'] : null,
            'catatan'                  => $data['catatan'] ?? $tanaman->catatan,
        ]);

        return back()->with('success', 'Panen berhasil dikonfirmasi! Total nilai: Rp ' .
            number_format($tanaman->fresh()->total_nilai_panen, 0, ',', '.'));
    }

    /** Petani mengklik: Tunda panen */
    public function tundaPanen(Request $request, Tanaman $tanaman)
    {
        abort_unless(in_array($tanaman->status, ['tumbuh', 'siap_panen', 'tunda']), 403, 'Status tidak dapat ditunda.');

        $data = $request->validate([
            'tunda_tanggal_baru' => 'required|date|after:today',
            'tunda_alasan'       => 'required|string|max:500',
        ]);

        $tanaman->update([
            'status'             => 'tunda',
            'tunda_tanggal_baru' => $data['tunda_tanggal_baru'],
            'tunda_alasan'       => $data['tunda_alasan'],
        ]);

        return back()->with('success', 'Panen ditunda ke ' . \Carbon\Carbon::parse($data['tunda_tanggal_baru'])->format('d/m/Y') . '.');
    }

    /** Petani mengklik: Gagal panen */
    public function gajalPanen(Request $request, Tanaman $tanaman)
    {
        abort_unless($tanaman->bisaGagal(), 403, 'Status tidak dapat diubah ke gagal.');

        $data = $request->validate([
            'gagal_alasan' => 'required|string|max:500',
        ]);

        $tanaman->update([
            'status'       => 'gagal',
            'gagal_alasan' => $data['gagal_alasan'],
        ]);

        return back()->with('success', 'Status diperbarui: Gagal Panen.');
    }

    // ── AJAX ──────────────────────────────────────────────────────

    public function getLahanByAnggota(Anggota $anggota)
    {
        $lahan = Lahan::where('anggota_id', $anggota->id)
            ->where('aktif', true)
            ->get(['id', 'nama_lahan', 'luas_lahan', 'satuan_luas']);
        return response()->json($lahan);
    }

    private function rules(): array
    {
        return [
            'anggota_id'       => 'nullable|exists:anggota,id',
            'lahan_id'         => 'required|exists:lahan,id',
            'sumber_bibit'     => 'required',
            'jumlah_bibit'     => 'required|integer|min:1',
            'jarak_tanam_x_cm' => 'required|integer|min:30|max:300',
            'jarak_tanam_y_cm' => 'required|integer|min:30|max:300',
            'tanggal_tanam'    => 'required|date',
            'estimasi_panen'   => 'nullable|date|after:tanggal_tanam',
            'status'           => 'required',
            'foto'             => 'nullable|image|max:2048',
        ];
    }
}
