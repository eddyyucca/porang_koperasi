<?php

namespace App\Http\Controllers;

use App\Models\HargaPorang;
use Illuminate\Http\Request;

class HargaPorangController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $riwayat    = HargaPorang::with('user')->orderByDesc('berlaku_mulai')->orderByDesc('id')->paginate(20);
        $hargaAktif = HargaPorang::hargaAktif();
        return view('harga-porang.index', compact('riwayat', 'hargaAktif'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'harga_per_kg'  => 'required|numeric|min:1',
            'berlaku_mulai' => 'required|date',
            'keterangan'    => 'nullable|string|max:300',
        ]);

        $data['user_id'] = auth()->id();

        HargaPorang::create($data);

        return back()->with('success', 'Harga Rp ' . number_format($data['harga_per_kg'], 0, ',', '.') . '/kg berhasil disimpan.');
    }

    public function destroy(HargaPorang $hargaPorang)
    {
        $this->authorizeAdmin();
        $hargaPorang->delete();
        return back()->with('success', 'Harga berhasil dihapus.');
    }

    /** AJAX: get current active price */
    public function hargaAktifApi()
    {
        $harga = HargaPorang::hargaAktif();
        return response()->json([
            'harga_per_kg'  => $harga?->harga_per_kg ?? 0,
            'harga_format'  => $harga?->harga_format ?? 'Belum ada harga',
            'berlaku_mulai' => $harga?->berlaku_mulai?->format('d/m/Y'),
        ]);
    }

    private function authorizeAdmin(): void
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses hanya untuk Admin.');
        }
    }
}
