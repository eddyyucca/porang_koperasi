<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Bumdes;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::with(['bumdes', 'koperasi']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%$s%")
                  ->orWhere('nik', 'like', "%$s%")
                  ->orWhere('nomor_anggota', 'like', "%$s%")
                  ->orWhere('telepon', 'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_anggota', $request->jenis);
        }

        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_ktp', 'like', '%' . $request->kabupaten . '%');
        }

        $anggota = $query->latest()->paginate(15)->withQueryString();

        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        $bumdes   = Bumdes::where('aktif', true)->orderBy('nama')->get();
        $koperasi = Koperasi::where('aktif', true)->orderBy('nama')->get();
        return view('anggota.create', compact('bumdes', 'koperasi'));
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        $data = $request->except(['foto_ktp', 'foto_diri']);
        $data['nomor_anggota'] = Anggota::generateNomorAnggota();

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }
        if ($request->hasFile('foto_diri')) {
            $data['foto_diri'] = $request->file('foto_diri')->store('foto_diri', 'public');
        }

        Anggota::create($data);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil disimpan.');
    }

    public function show(Anggota $anggota)
    {
        $anggota->load(['bumdes', 'koperasi', 'lahan.tanaman', 'panen']);
        return view('anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        $bumdes   = Bumdes::where('aktif', true)->orderBy('nama')->get();
        $koperasi = Koperasi::where('aktif', true)->orderBy('nama')->get();
        return view('anggota.edit', compact('anggota', 'bumdes', 'koperasi'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $rules = $this->rules($anggota->id);
        $request->validate($rules);

        $data = $request->except(['foto_ktp', 'foto_diri']);

        if ($request->hasFile('foto_ktp')) {
            if ($anggota->foto_ktp) Storage::disk('public')->delete($anggota->foto_ktp);
            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }
        if ($request->hasFile('foto_diri')) {
            if ($anggota->foto_diri) Storage::disk('public')->delete($anggota->foto_diri);
            $data['foto_diri'] = $request->file('foto_diri')->store('foto_diri', 'public');
        }

        $anggota->update($data);

        return redirect()->route('anggota.show', $anggota)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        if ($anggota->foto_ktp) Storage::disk('public')->delete($anggota->foto_ktp);
        if ($anggota->foto_diri) Storage::disk('public')->delete($anggota->foto_diri);
        $anggota->delete();
        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }

    public function approve(Anggota $anggota)
    {
        $anggota->update(['status' => 'aktif']);
        return back()->with('success', 'Anggota telah diaktifkan.');
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'nik'            => 'required|digits:16|unique:anggota,nik' . ($ignoreId ? ",$ignoreId" : ''),
            'nama_lengkap'   => 'required|string|max:100',
            'tempat_lahir'   => 'required|string|max:50',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'agama'          => 'required',
            'alamat_ktp'     => 'required|string',
            'jenis_anggota'  => 'required|in:personal,bumdes',
            'tanggal_daftar' => 'required|date',
            'foto_ktp'       => 'nullable|image|max:2048',
            'foto_diri'      => 'nullable|image|max:2048',
        ];
    }
}
