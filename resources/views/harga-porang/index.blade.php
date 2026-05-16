@extends('layouts.app')

@section('title', 'Harga Porang')
@section('page-title', 'Manajemen Harga Porang')
@section('breadcrumb')
    <li class="breadcrumb-item active">Harga Porang</li>
@endsection

@push('styles')
<style>
    .harga-hero {
        background: linear-gradient(135deg, #2e7d32, #43a047);
        border-radius: 16px;
        color: #fff;
        padding: 28px 32px;
        margin-bottom: 1.5rem;
    }
    .harga-hero .nilai { font-size: 2.8rem; font-weight: 800; letter-spacing: -0.02em; }
    .harga-hero .satuan { font-size: 1rem; opacity: .75; }
    .harga-hero .info { font-size: .85rem; opacity: .7; }
    .badge-superadmin { background: linear-gradient(135deg,#6f42c1,#9c27b0); color:#fff; padding:3px 10px; border-radius:50px; font-size:.7rem; font-weight:700; }
</style>
@endpush

@section('content')

{{-- Harga Aktif Hero --}}
<div class="harga-hero d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <div class="satuan mb-1"><i class="fas fa-tag me-1"></i> Harga Porang Aktif</div>
        @if($hargaAktif)
            <div class="nilai">{{ $hargaAktif->harga_format }}</div>
            <div class="info mt-1">per kilogram &bull; berlaku sejak {{ $hargaAktif->berlaku_mulai->format('d F Y') }}</div>
        @else
            <div class="nilai" style="font-size:1.8rem;">Belum ada harga</div>
            <div class="info">Tambahkan harga porang di bawah ini</div>
        @endif
    </div>
    <div class="text-right">
        <i class="fas fa-seedling" style="font-size:4rem; opacity:.25;"></i>
    </div>
</div>

<div class="row">
    {{-- Form Tambah Harga --}}
    <div class="col-md-5 mb-4">
        <div class="card h-100">
            <div class="card-header card-header-porang d-flex align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-plus-circle me-2"></i> Tetapkan Harga Baru</h3>
                <span class="badge-superadmin ml-auto"><i class="fas fa-shield-alt me-1"></i>Admin</span>
            </div>
            <div class="card-body">
                <form action="{{ route('harga-porang.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="font-weight-bold">Harga per Kg (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" name="harga_per_kg" class="form-control @error('harga_per_kg') is-invalid @enderror"
                            value="{{ old('harga_per_kg') }}"
                            placeholder="cth: 10000" min="1" step="1" required>
                        <div class="input-group-append">
                            <span class="input-group-text">/kg</span>
                        </div>
                        @error('harga_per_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <small class="text-muted">Masukkan harga dalam Rupiah per kilogram</small>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Berlaku Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="berlaku_mulai" class="form-control @error('berlaku_mulai') is-invalid @enderror"
                        value="{{ old('berlaku_mulai', today()->format('Y-m-d')) }}" required>
                    @error('berlaku_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Keterangan <span class="text-muted font-weight-normal">(opsional)</span></label>
                    <input type="text" name="keterangan" class="form-control"
                        value="{{ old('keterangan') }}"
                        placeholder="cth: Harga pasar lokal Mei 2026">
                </div>

                <button type="submit" class="btn btn-success btn-block">
                    <i class="fas fa-save me-1"></i> Simpan Harga
                </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Riwayat Harga --}}
    <div class="col-md-7 mb-4">
        <div class="card">
            <div class="card-header card-header-porang">
                <h3 class="card-title mb-0"><i class="fas fa-history me-2"></i> Riwayat Harga</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="40">#</th>
                                <th>Harga / Kg</th>
                                <th>Berlaku Mulai</th>
                                <th>Ditetapkan Oleh</th>
                                <th>Keterangan</th>
                                <th width="60">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $h)
                            <tr>
                                <td class="text-muted small">{{ $loop->iteration }}</td>
                                <td>
                                    <strong class="text-success">{{ $h->harga_format }}</strong>
                                    @if($hargaAktif && $h->id === $hargaAktif->id)
                                        <span class="badge badge-success ml-1" style="font-size:.65rem;">Aktif</span>
                                    @endif
                                </td>
                                <td class="small">{{ $h->berlaku_mulai->format('d/m/Y') }}</td>
                                <td class="small text-muted">{{ $h->user->name ?? '-' }}</td>
                                <td class="small text-muted">{{ $h->keterangan ?: '-' }}</td>
                                <td>
                                    <form action="{{ route('harga-porang.destroy', $h) }}" method="POST"
                                          onsubmit="return confirm('Hapus data harga ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-xs btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada riwayat harga
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($riwayat->hasPages())
            <div class="card-footer">{{ $riwayat->links() }}</div>
            @endif
        </div>
    </div>
</div>

@endsection
