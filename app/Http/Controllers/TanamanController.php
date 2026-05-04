<?php

namespace App\Http\Controllers;

use App\Models\Tanaman;
use App\Models\Lahan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TanamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tanaman::with(['anggota:id,nama_lengkap', 'lahan:id,nama_lahan']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('anggota', fn($q) => $q->where('nama_lengkap', 'like', "%$s%"))
                  ->orWhereHas('lahan', fn($q) => $q->where('nama_lahan', 'like', "%$s%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('varietas')) {
            $query->where('varietas', $request->varietas);
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
        }

        return view('tanaman.create', compact('anggota', 'lahan'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $data = $request->except('foto');

        // Auto hitung estimasi panen jika tidak diisi
        if (empty($data['estimasi_panen']) && !empty($data['tanggal_tanam'])) {
            $data['estimasi_panen'] = Tanaman::hitungEstimasiPanen($data['tanggal_tanam']);
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
        $tanaman->load(['anggota', 'lahan', 'panen' => fn($q) => $q->latest()]);
        return view('tanaman.show', compact('tanaman'));
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
        $request->validate($this->rules());
        $data = $request->except('foto');

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

    // AJAX: get lahan by anggota
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
            'anggota_id'    => 'required|exists:anggota,id',
            'lahan_id'      => 'required|exists:lahan,id',
            'varietas'      => 'required',
            'sumber_bibit'  => 'required',
            'jumlah_bibit'  => 'required|integer|min:1',
            'tanggal_tanam' => 'required|date',
            'estimasi_panen'=> 'nullable|date|after:tanggal_tanam',
            'status'        => 'required',
            'foto'          => 'nullable|image|max:2048',
        ];
    }
}
