<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use App\Models\Lahan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LahanController extends Controller
{
    public function index(Request $request)
    {
        $query = Lahan::with([
            'anggota:id,nama_lengkap,nomor_anggota',
            'bumdes:id,nama',
        ]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lahan', 'like', "%$s%")
                  ->orWhere('desa_nama', 'like', "%$s%")
                  ->orWhere('kabupaten_nama', 'like', "%$s%")
                  ->orWhereHas('anggota', fn($q2) => $q2->where('nama_lengkap', 'like', "%$s%"))
                  ->orWhereHas('bumdes', fn($q2) => $q2->where('nama', 'like', "%$s%"));
            });
        }

        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_nama', 'like', '%' . $request->kabupaten . '%');
        }

        if ($request->filled('status')) {
            $query->where('status_kepemilikan', $request->status);
        }

        if ($request->filled('pemilik_type')) {
            $query->where('pemilik_type', $request->pemilik_type);
        }

        $lahan = $query->latest()->paginate(15)->withQueryString();

        $lahanPeta = Lahan::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('aktif', true)
            ->with([
                'anggota:id,nama_lengkap',
                'bumdes:id,nama',
            ])
            ->select('id', 'nama_lahan', 'latitude', 'longitude', 'luas_lahan', 'satuan_luas', 'anggota_id', 'bumdes_id', 'pemilik_type', 'desa_nama', 'kabupaten_nama', 'status_kepemilikan')
            ->get();

        return view('lahan.index', compact('lahan', 'lahanPeta'));
    }

    public function create(Request $request)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);

        $bumdes = Bumdes::where('aktif', true)->orderBy('nama')->get(['id', 'nama']);

        $selectedAnggota = $request->filled('anggota_id')
            ? Anggota::find($request->anggota_id)
            : null;

        $selectedBumdes = $request->filled('bumdes_id')
            ? Bumdes::find($request->bumdes_id)
            : null;

        $defaultType = $request->filled('bumdes_id') ? 'bumdes' : 'petani';

        return view('lahan.create', compact('anggota', 'bumdes', 'selectedAnggota', 'selectedBumdes', 'defaultType'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules($request));

        // Clear the irrelevant owner fields
        if ($data['pemilik_type'] === 'bumdes') {
            $data['anggota_id'] = null;
        } else {
            $data['bumdes_id'] = null;
        }

        if ($request->hasFile('dokumen_file')) {
            $data['dokumen_file'] = $request->file('dokumen_file')->store('dokumen_lahan', 'public');
        }

        $lahan = Lahan::create($data);

        return redirect()->route('lahan.show', $lahan)
            ->with('success', 'Data lahan berhasil disimpan.');
    }

    public function show(Lahan $lahan)
    {
        $lahan->load(['anggota', 'bumdes', 'tanaman' => fn($q) => $q->latest(), 'panen' => fn($q) => $q->latest()]);
        return view('lahan.show', compact('lahan'));
    }

    public function edit(Lahan $lahan)
    {
        $anggota = Anggota::where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'nomor_anggota']);
        $bumdes = Bumdes::where('aktif', true)->orderBy('nama')->get(['id', 'nama']);

        return view('lahan.edit', compact('lahan', 'anggota', 'bumdes'));
    }

    public function update(Request $request, Lahan $lahan)
    {
        $data = $request->validate($this->rules($request));

        if ($data['pemilik_type'] === 'bumdes') {
            $data['anggota_id'] = null;
        } else {
            $data['bumdes_id'] = null;
        }

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

    private function rules(Request $request): array
    {
        $isPetani = $request->input('pemilik_type', 'petani') === 'petani';

        return [
            'pemilik_type'      => 'required|in:petani,bumdes',
            'anggota_id'        => $isPetani ? 'required|exists:anggota,id' : 'nullable|exists:anggota,id',
            'bumdes_id'         => !$isPetani ? 'required|exists:bumdes,id' : 'nullable|exists:bumdes,id',
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
