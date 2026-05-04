<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LahanController extends Controller
{
    public function index(Request $request)
    {
        $query = Lahan::with([
            'anggota:id,nama_lengkap,nomor_anggota,jenis_anggota,bumdes_id',
            'anggota.bumdes:id,nama',
        ]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lahan', 'like', "%$s%")
                  ->orWhere('desa_nama', 'like', "%$s%")
                  ->orWhere('kabupaten_nama', 'like', "%$s%")
                  ->orWhereHas('anggota', fn($q2) => $q2->where('nama_lengkap', 'like', "%$s%"));
            });
        }

        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_nama', 'like', '%' . $request->kabupaten . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_kepemilikan', $request->status);
        }

        $lahan = $query->latest()->paginate(15)->withQueryString();

        // Data untuk peta semua lahan
        $lahanPeta = Lahan::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('aktif', true)
            ->with([
                'anggota:id,nama_lengkap,jenis_anggota,bumdes_id',
                'anggota.bumdes:id,nama',
            ])
            ->select('id', 'nama_lahan', 'latitude', 'longitude', 'luas_lahan', 'satuan_luas', 'anggota_id', 'desa_nama', 'kabupaten_nama', 'status_kepemilikan')
            ->get();

        return view('lahan.index', compact('lahan', 'lahanPeta'));
    }

    public function create(Request $request)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);

        $selectedAnggota = $request->filled('anggota_id')
            ? Anggota::find($request->anggota_id)
            : null;

        return view('lahan.create', compact('anggota', 'selectedAnggota'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $data = $request->except('dokumen_file');

        if ($request->hasFile('dokumen_file')) {
            $data['dokumen_file'] = $request->file('dokumen_file')->store('dokumen_lahan', 'public');
        }

        $lahan = Lahan::create($data);

        return redirect()->route('lahan.show', $lahan)
            ->with('success', 'Data lahan berhasil disimpan.');
    }

    public function show(Lahan $lahan)
    {
        $lahan->load(['anggota', 'tanaman' => fn($q) => $q->latest(), 'panen' => fn($q) => $q->latest()]);
        return view('lahan.show', compact('lahan'));
    }

    public function edit(Lahan $lahan)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);
        return view('lahan.edit', compact('lahan', 'anggota'));
    }

    public function update(Request $request, Lahan $lahan)
    {
        $request->validate($this->rules());

        $data = $request->except('dokumen_file');

        if ($request->hasFile('dokumen_file')) {
            if ($lahan->dokumen_file) Storage::disk('public')->delete($lahan->dokumen_file);
            $data['dokumen_file'] = $request->file('dokumen_file')->store('dokumen_lahan', 'public');
        }

        $lahan->update($data);

        return redirect()->route('lahan.show', $lahan)
            ->with('success', 'Data lahan berhasil diperbarui.');
    }

    public function destroy(Lahan $lahan)
    {
        if ($lahan->dokumen_file) Storage::disk('public')->delete($lahan->dokumen_file);
        $lahan->delete();
        return redirect()->route('lahan.index')->with('success', 'Data lahan berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'anggota_id'        => 'required|exists:anggota,id',
            'nama_lahan'        => 'required|string|max:100',
            'luas_lahan'        => 'required|numeric|min:1',
            'satuan_luas'       => 'required|in:m2,ha,are',
            'status_kepemilikan'=> 'required',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'dokumen_file'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }
}
