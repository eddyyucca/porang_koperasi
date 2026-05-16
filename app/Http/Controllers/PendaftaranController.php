<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Bumdes;
use App\Models\KelompokTani;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PendaftaranController extends Controller
{
    public function showForm()
    {
        $kelompokTani = KelompokTani::where('status', 'aktif')->orderBy('nama_kelompok')->get();
        $bumdes       = Bumdes::where('aktif', true)->orderBy('nama')->get();
        $koperasi     = Koperasi::where('aktif', true)->orderBy('nama')->first();

        return view('pendaftaran.daftar', compact('kelompokTani', 'bumdes', 'koperasi'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_anggota'    => 'required|in:mandiri,kelompok_tani,bumdes',
            'kelompok_tani_id' => ['nullable', Rule::requiredIf($request->jenis_anggota === 'kelompok_tani'), 'exists:kelompok_tani,id'],
            'bumdes_id'        => ['nullable', Rule::requiredIf($request->jenis_anggota === 'bumdes'), 'exists:bumdes,id'],
            'nama_lengkap'     => 'required|string|max:100',
            'nik'              => 'required|digits:16|unique:anggota,nik',
            'tempat_lahir'     => 'required|string|max:50',
            'tanggal_lahir'    => 'required|date',
            'jenis_kelamin'    => 'required|in:L,P',
            'agama'            => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'telepon'          => 'required|string|max:20',
            'email'            => 'nullable|email|max:100',
            'alamat_ktp'       => 'required|string',
            'provinsi_id_ktp'  => 'nullable|string|max:15',
            'provinsi_ktp'     => 'nullable|string|max:100',
            'kabupaten_id_ktp' => 'nullable|string|max:15',
            'kabupaten_ktp'    => 'nullable|string|max:100',
            'kecamatan_id_ktp' => 'nullable|string|max:15',
            'kecamatan_ktp'    => 'nullable|string|max:100',
            'desa_id_ktp'      => 'nullable|string|max:15',
            'desa_ktp'         => 'nullable|string|max:100',
        ]);

        // Bersihkan relasi yang tidak relevan
        if ($data['jenis_anggota'] !== 'kelompok_tani') {
            $data['kelompok_tani_id'] = null;
        }
        if ($data['jenis_anggota'] !== 'bumdes') {
            $data['bumdes_id'] = null;
        }

        $data['nomor_anggota'] = Anggota::generateNomorAnggota();
        $data['tanggal_daftar'] = now()->toDateString();
        $data['status']         = 'pending';

        // Hubungkan ke koperasi aktif pertama jika ada
        $koperasi = Koperasi::where('aktif', true)->first();
        if ($koperasi) {
            $data['koperasi_id'] = $koperasi->id;
        }

        Anggota::create($data);

        return redirect()->route('daftar.sukses');
    }

    public function sukses()
    {
        return view('pendaftaran.sukses');
    }
}
