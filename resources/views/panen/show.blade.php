@extends('layouts.app')

@section('title', 'Detail Panen')
@section('page-title', 'Detail Data Panen')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('panen.index') }}">Panen</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Info Panen</h3></div>
            <div class="card-body">
                <div class="mb-3"><small class="text-muted d-block">Tanggal Panen</small><strong>{{ optional($panen->tanggal_panen)->format('d M Y') }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Petani</small><strong>{{ $panen->anggota->nama_lengkap ?? '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Kualitas</small><span class="badge badge-{{ $panen->kualitas_badge }}">{{ $panen->kualitas }}</span></div>
                <div><small class="text-muted d-block">Status Jual</small><strong>{{ ucfirst($panen->status_jual) }}</strong></div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Tanaman Asal</h3></div>
            <div class="card-body">
                @if($panen->tanaman)
                    <a href="{{ route('tanaman.show', $panen->tanaman) }}"><strong>{{ $panen->tanaman->varietas }}</strong></a>
                    <p class="text-muted mb-0 mt-2">Tanggal tanam: {{ optional($panen->tanaman->tanggal_tanam)->format('d/m/Y') ?: '-' }}</p>
                @else
                    <p class="mb-0">-</p>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Lahan</h3></div>
            <div class="card-body">
                @if($panen->lahan)
                    <a href="{{ route('lahan.show', $panen->lahan) }}"><strong>{{ $panen->lahan->nama_lahan }}</strong></a>
                    <p class="text-muted mb-0 mt-2">{{ $panen->lahan->lokasi ?: '-' }}</p>
                @else
                    <p class="mb-0">-</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Nilai Transaksi</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Berat</small><strong>{{ number_format($panen->berat_panen_kg, 2, ',', '.') }} kg</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Harga per kg</small><strong>Rp {{ number_format($panen->harga_per_kg ?? 0, 0, ',', '.') }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Total Nilai</small><strong>Rp {{ number_format($panen->total_nilai ?? 0, 0, ',', '.') }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Pembeli</small><strong>{{ $panen->pembeli ?: '-' }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Metode Jual</small><strong>{{ ucfirst($panen->metode_jual) }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Status Jual</small><strong>{{ ucfirst($panen->status_jual) }}</strong></div>
                </div>
                @if($panen->catatan)
                    <hr>
                    <small class="text-muted d-block">Catatan</small>
                    <p class="mb-0">{{ $panen->catatan }}</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header-porang"><h3 class="card-title">Foto Panen</h3></div>
            <div class="card-body">
                @if($panen->foto)
                    <img src="{{ asset('storage/' . $panen->foto) }}" alt="Foto Panen" class="img-fluid rounded border">
                @else
                    <div class="alert alert-light border mb-0">Foto panen belum tersedia.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
