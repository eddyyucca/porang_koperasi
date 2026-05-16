<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Tanaman;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanenController extends Controller
{
    public function index(Request $request)
    {
        $query = Panen::with([
            'anggota:id,nama_lengkap',
            'lahan:id,nama_lahan',
            'tanaman:id,varietas,tanggal_tanam',
        ]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('anggota', fn($q) => $q->where('nama_lengkap', 'like', "%$s%"));
        }

        if ($request->filled('metode')) {
            $query->where('metode_jual', $request->metode);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_panen', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_panen', $request->tahun);
        }

        $panen = $query->latest('tanggal_panen')->paginate(15)->withQueryString();

        $totalKg    = Panen::sum('berat_panen_kg');
        $totalNilai = Panen::sum('total_nilai');

        return view('panen.index', compact('panen', 'totalKg', 'totalNilai'));
    }

    public function create(Request $request)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);

        $tanaman = collect();
        if ($request->filled('anggota_id')) {
            $tanaman = Tanaman::where('anggota_id', $request->anggota_id)
                ->whereIn('status', ['tumbuh', 'panen'])
                ->with('lahan:id,nama_lahan')
                ->get();
        }

        return view('panen.create', compact('anggota', 'tanaman'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $data = $request->except('foto');

        $tanaman = Tanaman::with('lahan')->findOrFail($data['tanaman_id']);
        $data['lahan_id']   = $tanaman->lahan_id;
        $data['anggota_id'] = $tanaman->anggota_id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('panen', 'public');
        }

        $panen = Panen::create($data);

        // Update status tanaman menjadi panen
        $tanaman->update(['status' => 'panen', 'tanggal_panen_aktual' => $data['tanggal_panen']]);

        return redirect()->route('panen.show', $panen)
            ->with('success', 'Data panen berhasil disimpan.');
    }

    public function show(Panen $panen)
    {
        $panen->load(['anggota', 'lahan', 'tanaman']);
        return view('panen.show', compact('panen'));
    }

    public function edit(Panen $panen)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);

        $tanaman = Tanaman::where('anggota_id', $panen->anggota_id)
            ->with('lahan:id,nama_lahan')
            ->get();

        return view('panen.edit', compact('panen', 'anggota', 'tanaman'));
    }

    public function update(Request $request, Panen $panen)
    {
        $request->validate($this->rules());
        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($panen->foto) Storage::disk('public')->delete($panen->foto);
            $data['foto'] = $request->file('foto')->store('panen', 'public');
        }

        $panen->update($data);

        return redirect()->route('panen.show', $panen)
            ->with('success', 'Data panen berhasil diperbarui.');
    }

    public function destroy(Panen $panen)
    {
        if ($panen->foto) Storage::disk('public')->delete($panen->foto);
        $panen->delete();
        return redirect()->route('panen.index')->with('success', 'Data panen berhasil dihapus.');
    }

    // AJAX: get tanaman by anggota
    public function getTanamanByAnggota(Anggota $anggota)
    {
        $tanaman = Tanaman::where('anggota_id', $anggota->id)
            ->whereIn('status', ['tumbuh', 'panen'])
            ->with('lahan:id,nama_lahan')
            ->get(['id', 'varietas', 'tanggal_tanam', 'lahan_id', 'status']);
        return response()->json($tanaman);
    }

    private function rules(): array
    {
        return [
            'tanaman_id'    => 'required|exists:tanaman,id',
            'tanggal_panen' => 'required|date',
            'berat_panen_kg'=> 'required|numeric|min:0.1',
            'harga_per_kg'  => 'nullable|numeric|min:0',
            'metode_jual'   => 'required',
            'foto'          => 'nullable|image|max:2048',
        ];
    }
}
