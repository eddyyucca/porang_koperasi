<?php

namespace App\Http\Controllers;

use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KoperasiController extends Controller
{
    public function index()
    {
        $koperasi = Koperasi::first();
        return view('koperasi.index', compact('koperasi'));
    }

    public function edit()
    {
        $koperasi = Koperasi::firstOrNew([]);
        return view('koperasi.edit', compact('koperasi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'               => 'required|string|max:150',
            'alamat'             => 'required|string',
            'nomor_badan_hukum'  => 'nullable|string|max:100',
            'tanggal_berdiri'    => 'nullable|date',
            'ketua'              => 'nullable|string|max:100',
            'sekretaris'         => 'nullable|string|max:100',
            'bendahara'          => 'nullable|string|max:100',
            'telepon'            => 'nullable|string|max:20',
            'email'              => 'nullable|email',
            'logo'               => 'nullable|image|max:1024',
        ]);

        $koperasi = Koperasi::firstOrNew([]);
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            if ($koperasi->logo) Storage::disk('public')->delete($koperasi->logo);
            $data['logo'] = $request->file('logo')->store('koperasi', 'public');
        }

        $koperasi->fill($data);
        $koperasi->save();

        return redirect()->route('koperasi.index')->with('success', 'Data koperasi berhasil disimpan.');
    }
}
