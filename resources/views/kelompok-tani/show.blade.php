@extends('layouts.app')

@section('title', $kelompokTani->nama_kelompok)
@section('page-title', 'Detail Kelompok Tani')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kelompok-tani.index') }}">Kelompok Tani</a></li>
    <li class="breadcrumb-item active">{{ $kelompokTani->nama_kelompok }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">

        {{-- Info Utama --}}
        <div class="card mb-3">
            <div class="card-header card-header-porang d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0"><i class="fas fa-people-group me-2"></i> {{ $kelompokTani->nama_kelompok }}</h3>
                <div class="d-flex gap-1">
                    @if($kelompokTani->status === 'pending')
                        <form action="{{ route('kelompok-tani.approve', $kelompokTani) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm" onclick="return confirm('Setujui kelompok tani ini?')">
                                <i class="fas fa-check me-1"></i> Setujui
                            </button>
                        </form>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalTolak">
                            <i class="fas fa-times me-1"></i> Tolak
                        </button>
                    @endif
                    <a href="{{ route('kelompok-tani.edit', $kelompokTani) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="text-muted" style="width:140px">Status</th>
                                <td>
                                    @if($kelompokTani->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif($kelompokTani->status === 'pending')
                                        <span class="badge badge-warning text-dark">Menunggu Verifikasi</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Nomor SK</th>
                                <td>{{ $kelompokTani->nomor_sk ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tahun Berdiri</th>
                                <td>{{ $kelompokTani->tahun_berdiri ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Komoditas</th>
                                <td>{{ $kelompokTani->komoditas_utama }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Total Lahan</th>
                                <td>
                                    {{ number_format($kelompokTani->luas_lahan_total, 0, ',', '.') }} m²
                                    <small class="text-muted">({{ number_format($kelompokTani->luas_hektar, 4, ',', '.') }} Ha)</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th class="text-muted" style="width:140px">BUMDes</th>
                                <td>{{ $kelompokTani->bumdes->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Koperasi</th>
                                <td>{{ $kelompokTani->koperasi->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Jumlah Anggota</th>
                                <td>{{ $kelompokTani->anggota->count() }} orang terdaftar</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Wilayah</th>
                                <td>
                                    @php
                                        $parts = array_filter([$kelompokTani->desa_nama, $kelompokTani->kecamatan_nama, $kelompokTani->kabupaten_nama, $kelompokTani->provinsi_nama]);
                                    @endphp
                                    {{ implode(', ', $parts) ?: '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Alamat</th>
                                <td>{{ $kelompokTani->alamat ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($kelompokTani->catatan)
                <div class="alert alert-warning mt-2 mb-0 py-2">
                    <strong><i class="fas fa-comment-alt me-1"></i> Catatan:</strong> {{ $kelompokTani->catatan }}
                </div>
                @endif
            </div>
        </div>

        {{-- Pengurus --}}
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title mb-0"><i class="fas fa-user-tie me-2"></i> Data Pengurus</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        <div style="background:#e8f5e9;border-radius:50%;width:64px;height:64px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                            <i class="fas fa-user text-success fa-2x"></i>
                        </div>
                        <p class="font-weight-bold mb-0">{{ $kelompokTani->ketua_nama }}</p>
                        <small class="text-muted">Ketua</small>
                        @if($kelompokTani->ketua_telepon)
                            <br><small class="text-success"><i class="fas fa-phone me-1"></i>{{ $kelompokTani->ketua_telepon }}</small>
                        @endif
                        @if($kelompokTani->ketua_nik)
                            <br><small class="text-muted">NIK: {{ $kelompokTani->ketua_nik }}</small>
                        @endif
                    </div>
                    <div class="col-md-4 text-center mb-3 mb-md-0">
                        <div style="background:#e3f2fd;border-radius:50%;width:64px;height:64px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                            <i class="fas fa-user text-primary fa-2x"></i>
                        </div>
                        <p class="font-weight-bold mb-0">{{ $kelompokTani->sekretaris ?: '-' }}</p>
                        <small class="text-muted">Sekretaris</small>
                    </div>
                    <div class="col-md-4 text-center">
                        <div style="background:#fff3e0;border-radius:50%;width:64px;height:64px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
                            <i class="fas fa-user text-warning fa-2x"></i>
                        </div>
                        <p class="font-weight-bold mb-0">{{ $kelompokTani->bendahara ?: '-' }}</p>
                        <small class="text-muted">Bendahara</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Anggota --}}
        <div class="card mb-3">
            <div class="card-header card-header-porang d-flex align-items-center justify-content-between">
                <h3 class="card-title mb-0"><i class="fas fa-users me-2"></i> Anggota Terdaftar</h3>
                <span class="badge badge-light">{{ $kelompokTani->anggota->count() }} orang</span>
            </div>
            <div class="card-body p-0">
                @if($kelompokTani->anggota->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>No. Anggota</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelompokTani->anggota as $a)
                            <tr>
                                <td>
                                    <a href="{{ route('anggota.show', $a) }}" class="text-primary">{{ $a->nomor_anggota }}</a>
                                </td>
                                <td>{{ $a->nama_lengkap }}</td>
                                <td>{{ $a->telepon ?: '-' }}</td>
                                <td>
                                    @if($a->status === 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif($a->status === 'pending')
                                        <span class="badge badge-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $a->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                    Belum ada anggota yang terhubung ke kelompok tani ini
                </div>
                @endif
            </div>
        </div>

    </div>

    <div class="col-md-4">
        {{-- Foto --}}
        @if($kelompokTani->foto)
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title mb-0">Foto Kelompok</h3>
            </div>
            <div class="card-body p-2">
                <img src="{{ asset('storage/'.$kelompokTani->foto) }}" class="img-fluid rounded" alt="Foto Kelompok">
            </div>
        </div>
        @endif

        {{-- Quick Stats --}}
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title mb-0">Statistik</h3>
            </div>
            <div class="card-body">
                <div class="info-box bg-success mb-2">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Anggota</span>
                        <span class="info-box-number">{{ $kelompokTani->anggota->count() }}</span>
                    </div>
                </div>
                <div class="info-box bg-primary mb-2">
                    <span class="info-box-icon"><i class="fas fa-map"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Lahan</span>
                        <span class="info-box-number">{{ number_format($kelompokTani->luas_hektar, 2, ',', '.') }} Ha</span>
                    </div>
                </div>
                <div class="info-box bg-warning mb-0">
                    <span class="info-box-icon"><i class="fas fa-seedling"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Komoditas</span>
                        <span class="info-box-number" style="font-size:1rem">{{ $kelompokTani->komoditas_utama }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aksi --}}
        <div class="card">
            <div class="card-body">
                <a href="{{ route('kelompok-tani.edit', $kelompokTani) }}" class="btn btn-warning btn-block mb-2">
                    <i class="fas fa-edit me-1"></i> Edit Data
                </a>
                <form action="{{ route('kelompok-tani.destroy', $kelompokTani) }}" method="POST"
                      onsubmit="return confirm('Hapus kelompok tani {{ $kelompokTani->nama_kelompok }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-block">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tolak --}}
@if($kelompokTani->status === 'pending')
<div class="modal fade" id="modalTolak" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('kelompok-tani.reject', $kelompokTani) }}" method="POST">
            @csrf @method('PATCH')
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Tolak Pendaftaran</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Berikan alasan penolakan kepada kelompok tani <strong>{{ $kelompokTani->nama_kelompok }}</strong>:</p>
                    <div class="form-group">
                        <label class="font-weight-bold">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="catatan" class="form-control" rows="3" required
                            placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
