<?php

namespace App\Http\Controllers;

use App\Models\KelompokTani;
use App\Models\Bumdes;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelompokTaniController extends Controller
{
    public function index(Request $request)
    {
        $query = KelompokTani::with(['bumdes', 'koperasi', 'anggota']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_kelompok', 'like', "%$s%")
                  ->orWhere('ketua_nama', 'like', "%$s%")
                  ->orWhere('kabupaten_nama', 'like', "%$s%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kabupaten')) {
            $query->where('kabupaten_nama', 'like', '%' . $request->kabupaten . '%');
        }

        $kelompokTani = $query->latest()->paginate(15)->withQueryString();

        return view('kelompok-tani.index', compact('kelompokTani'));
    }

    public function create()
    {
        $bumdes   = Bumdes::where('aktif', true)->orderBy('nama')->get();
        $koperasi = Koperasi::where('aktif', true)->orderBy('nama')->get();
        return view('kelompok-tani.create', compact('bumdes', 'koperasi'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kelompok_tani', 'public');
        }

        KelompokTani::create($data);

        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data kelompok tani berhasil disimpan.');
    }

    public function show(KelompokTani $kelompokTani)
    {
        $kelompokTani->load(['bumdes', 'koperasi', 'anggota']);
        return view('kelompok-tani.show', compact('kelompokTani'));
    }

    public function edit(KelompokTani $kelompokTani)
    {
        $bumdes   = Bumdes::where('aktif', true)->orderBy('nama')->get();
        $koperasi = Koperasi::where('aktif', true)->orderBy('nama')->get();
        return view('kelompok-tani.edit', compact('kelompokTani', 'bumdes', 'koperasi'));
    }

    public function update(Request $request, KelompokTani $kelompokTani)
    {
        $data = $request->validate($this->rules());

        if ($request->hasFile('foto')) {
            if ($kelompokTani->foto) {
                Storage::disk('public')->delete($kelompokTani->foto);
            }
            $data['foto'] = $request->file('foto')->store('kelompok_tani', 'public');
        }

        $kelompokTani->update($data);

        return redirect()->route('kelompok-tani.show', $kelompokTani)
            ->with('success', 'Data kelompok tani berhasil diperbarui.');
    }

    public function destroy(KelompokTani $kelompokTani)
    {
        if ($kelompokTani->foto) {
            Storage::disk('public')->delete($kelompokTani->foto);
        }
        $kelompokTani->delete();
        return redirect()->route('kelompok-tani.index')
            ->with('success', 'Data kelompok tani berhasil dihapus.');
    }

    public function approve(KelompokTani $kelompokTani)
    {
        $kelompokTani->update(['status' => 'aktif']);
        return back()->with('success', 'Kelompok tani telah diaktifkan.');
    }

    public function reject(Request $request, KelompokTani $kelompokTani)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $kelompokTani->update([
            'status'  => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Kelompok tani telah ditolak.');
    }

    private function rules(): array
    {
        return [
            'nama_kelompok'    => 'required|string|max:150',
            'ketua_nama'       => 'required|string|max:100',
            'ketua_nik'        => 'nullable|string|max:16',
            'ketua_telepon'    => 'nullable|string|max:20',
            'sekretaris'       => 'nullable|string|max:100',
            'bendahara'        => 'nullable|string|max:100',
            'nomor_sk'         => 'nullable|string|max:100',
            'provinsi_id'      => 'nullable|string|max:15',
            'provinsi_nama'    => 'nullable|string|max:100',
            'kabupaten_id'     => 'nullable|string|max:15',
            'kabupaten_nama'   => 'nullable|string|max:100',
            'kecamatan_id'     => 'nullable|string|max:15',
            'kecamatan_nama'   => 'nullable|string|max:100',
            'desa_id'          => 'nullable|string|max:15',
            'desa_nama'        => 'nullable|string|max:100',
            'alamat'           => 'nullable|string',
            'tahun_berdiri'    => 'nullable|integer|min:1900|max:' . date('Y'),
            'jumlah_anggota'   => 'nullable|integer|min:0',
            'komoditas_utama'  => 'nullable|string|max:100',
            'luas_lahan_total' => 'nullable|numeric|min:0',
            'bumdes_id'        => 'nullable|exists:bumdes,id',
            'koperasi_id'      => 'nullable|exists:koperasi,id',
            'status'           => 'nullable|in:aktif,pending,ditolak',
            'catatan'          => 'nullable|string',
            'foto'             => 'nullable|image|max:2048',
        ];
    }
}
