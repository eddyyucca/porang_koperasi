<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Bumdes;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $data = $this->validatedData($request);
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
        $data = $this->validatedData($request, $anggota->id);

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

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate($this->rules($ignoreId));

        if (($data['jenis_anggota'] ?? null) !== 'bumdes') {
            $data['bumdes_id'] = null;
        }

        return $data;
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'nik'                => ['required', 'digits:16', Rule::unique('anggota', 'nik')->ignore($ignoreId)],
            'nama_lengkap'       => 'required|string|max:100',
            'tempat_lahir'       => 'required|string|max:50',
            'tanggal_lahir'      => 'required|date',
            'jenis_kelamin'      => 'required|in:L,P',
            'golongan_darah'     => 'nullable|in:-,A,B,AB,O',
            'agama'              => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan'  => 'nullable|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pendidikan'         => 'nullable|string|max:50',
            'pekerjaan_ktp'      => 'nullable|string|max:100',
            'alamat_ktp'         => 'required|string',
            'rt_ktp'             => 'nullable|string|max:5',
            'rw_ktp'             => 'nullable|string|max:5',
            'desa_id_ktp'        => 'nullable|string|max:15',
            'desa_ktp'           => 'nullable|string|max:100',
            'kecamatan_id_ktp'   => 'nullable|string|max:15',
            'kecamatan_ktp'      => 'nullable|string|max:100',
            'kabupaten_id_ktp'   => 'nullable|string|max:15',
            'kabupaten_ktp'      => 'nullable|string|max:100',
            'provinsi_id_ktp'    => 'nullable|string|max:15',
            'provinsi_ktp'       => 'nullable|string|max:100',
            'kode_pos_ktp'       => 'nullable|string|max:10',
            'telepon'            => 'nullable|string|max:20',
            'email'              => 'nullable|email|max:100',
            'jenis_anggota'      => 'required|in:personal,bumdes',
            'bumdes_id'          => 'nullable|required_if:jenis_anggota,bumdes|exists:bumdes,id',
            'koperasi_id'        => 'nullable|exists:koperasi,id',
            'tanggal_daftar'     => 'required|date',
            'status'             => 'nullable|in:aktif,non-aktif,pending',
            'no_rekening'        => 'nullable|string|max:50',
            'nama_bank'          => 'nullable|string|max:100',
            'catatan'            => 'nullable|string',
            'foto_ktp'           => 'nullable|image|max:2048',
            'foto_diri'          => 'nullable|image|max:2048',
        ];
    }
}
