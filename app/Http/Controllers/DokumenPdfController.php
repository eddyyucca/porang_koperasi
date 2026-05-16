<?php

namespace App\Http\Controllers;

use App\Models\DokumenPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenPdfController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeSuperAdmin();

        $query = DokumenPdf::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $dokumen = $query->latest()->paginate(15)->withQueryString();

        return view('dokumen-pdf.index', compact('dokumen'));
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        $request->validate([
            'nama'       => 'required|string|max:255',
            'file'       => 'required|file|mimes:pdf|max:20480', // max 20 MB
            'deskripsi'  => 'nullable|string|max:500',
        ]);

        $file     = $request->file('file');
        $slug     = Str::slug($request->nama) ?: 'dokumen';
        $filename = $slug . '_' . time() . '.pdf';
        $path     = $file->storeAs('dokumen_pdf', $filename, 'public');

        DokumenPdf::create([
            'nama'       => $request->nama,
            'file_path'  => $path,
            'ukuran'     => $file->getSize(),
            'deskripsi'  => $request->deskripsi,
        ]);

        return back()->with('success', 'Dokumen "' . $request->nama . '" berhasil diunggah.');
    }

    public function download(DokumenPdf $dokumenPdf)
    {
        $this->authorizeSuperAdmin();

        if (!Storage::disk('public')->exists($dokumenPdf->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $dokumenPdf->file_path,
            Str::slug($dokumenPdf->nama) . '.pdf'
        );
    }

    public function destroy(DokumenPdf $dokumenPdf)
    {
        $this->authorizeSuperAdmin();

        if ($dokumenPdf->file_path && Storage::disk('public')->exists($dokumenPdf->file_path)) {
            Storage::disk('public')->delete($dokumenPdf->file_path);
        }

        $nama = $dokumenPdf->nama;
        $dokumenPdf->delete();

        return back()->with('success', 'Dokumen "' . $nama . '" berhasil dihapus.');
    }

    private function authorizeSuperAdmin(): void
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Akses hanya untuk Super Admin.');
        }
    }
}
