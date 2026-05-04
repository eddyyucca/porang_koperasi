<?php

namespace App\Http\Controllers;

use App\Models\Bumdes;
use Illuminate\Http\Request;

class BumdesController extends Controller
{
    public function index(Request $request)
    {
        $query = Bumdes::withCount('anggota');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                  ->orWhere('kabupaten_nama', 'like', "%$s%")
                  ->orWhere('desa_nama', 'like', "%$s%");
            });
        }

        $bumdes = $query->orderBy('nama')->paginate(15)->withQueryString();
        return view('bumdes.index', compact('bumdes'));
    }

    public function create()
    {
        return view('bumdes.create');
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());
        Bumdes::create($request->all());
        return redirect()->route('bumdes.index')->with('success', 'Data BUMDes berhasil disimpan.');
    }

    public function show(Bumdes $bumdes)
    {
        $bumdes->load(['anggota' => fn($q) => $q->latest()->limit(10)]);
        return view('bumdes.show', compact('bumdes'));
    }

    public function edit(Bumdes $bumdes)
    {
        return view('bumdes.edit', compact('bumdes'));
    }

    public function update(Request $request, Bumdes $bumdes)
    {
        $request->validate($this->rules());
        $bumdes->update($request->all());
        return redirect()->route('bumdes.show', $bumdes)->with('success', 'Data BUMDes berhasil diperbarui.');
    }

    public function destroy(Bumdes $bumdes)
    {
        $bumdes->delete();
        return redirect()->route('bumdes.index')->with('success', 'Data BUMDes berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nama'           => 'required|string|max:150',
            'alamat'         => 'required|string',
            'direktur'       => 'nullable|string|max:100',
            'telepon'        => 'nullable|string|max:20',
            'email'          => 'nullable|email',
            'provinsi_nama'  => 'nullable|string',
            'kabupaten_nama' => 'nullable|string',
            'kecamatan_nama' => 'nullable|string',
            'desa_nama'      => 'nullable|string',
        ];
    }
}
