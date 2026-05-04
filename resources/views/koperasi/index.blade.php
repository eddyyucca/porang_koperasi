@extends('layouts.app')

@section('title', 'Profil Koperasi')
@section('page-title', 'Profil Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Koperasi</li>
@endsection

@section('content')
@php
    $totalAnggotaAktif = \App\Models\Anggota::where('status', 'aktif')->count();
    $totalLahan = \App\Models\Lahan::count();
    $totalPanen = \App\Models\Panen::sum('berat_panen_kg');
    $logoPlaceholder = 'https://placehold.co/600x400/e9ecef/6c757d?text=Logo+Koperasi';
@endphp

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-building mr-2"></i>Profil Utama</h3>
            </div>
            <div class="card-body text-center">
                <img src="{{ $koperasi && $koperasi->logo ? asset('storage/' . $koperasi->logo) : $logoPlaceholder }}" alt="Logo Koperasi" class="img-fluid rounded border mb-3" style="max-height:220px;">
                <h4 class="font-weight-bold mb-1">{{ optional($koperasi)->nama ?: 'Koperasi Tani Porang' }}</h4>
                <p class="text-muted mb-2">Nomor Badan Hukum: {{ optional($koperasi)->nomor_badan_hukum ?: '-' }}</p>
                <p class="mb-0">Tanggal Berdiri: {{ optional($koperasi?->tanggal_berdiri)->format('d M Y') ?: '-' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Statistik</h3>
            </div>
            <div class="card-body">
                <div class="mb-3"><small class="text-muted d-block">Total Anggota Aktif</small><strong>{{ number_format($totalAnggotaAktif) }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Total Lahan</small><strong>{{ number_format($totalLahan) }}</strong></div>
                <div><small class="text-muted d-block">Total Panen</small><strong>{{ number_format($totalPanen, 2, ',', '.') }} kg</strong></div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-user-tie mr-2"></i>Pengurus</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Ketua</small><strong>{{ optional($koperasi)->ketua ?: '-' }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Sekretaris</small><strong>{{ optional($koperasi)->sekretaris ?: '-' }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Bendahara</small><strong>{{ optional($koperasi)->bendahara ?: '-' }}</strong></div>
                    <div class="col-md-6 mb-3"><small class="text-muted d-block">Telepon</small><strong>{{ optional($koperasi)->telepon ?: '-' }}</strong></div>
                    <div class="col-md-6 mb-3"><small class="text-muted d-block">Email</small><strong>{{ optional($koperasi)->email ?: '-' }}</strong></div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-map-marker-alt mr-2"></i>Alamat Lengkap</h3>
            </div>
            <div class="card-body">
                <p class="mb-3">{{ optional($koperasi)->alamat ?: '-' }}</p>
                <div class="row">
                    <div class="col-md-3 mb-2"><small class="text-muted d-block">Desa</small><strong>{{ optional($koperasi)->desa_nama ?: '-' }}</strong></div>
                    <div class="col-md-3 mb-2"><small class="text-muted d-block">Kecamatan</small><strong>{{ optional($koperasi)->kecamatan_nama ?: '-' }}</strong></div>
                    <div class="col-md-3 mb-2"><small class="text-muted d-block">Kabupaten</small><strong>{{ optional($koperasi)->kabupaten_nama ?: '-' }}</strong></div>
                    <div class="col-md-3 mb-2"><small class="text-muted d-block">Provinsi</small><strong>{{ optional($koperasi)->provinsi_nama ?: '-' }}</strong></div>
                    <div class="col-md-3 mb-2"><small class="text-muted d-block">Kode Pos</small><strong>{{ optional($koperasi)->kode_pos ?: '-' }}</strong></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-bullseye mr-2"></i>Visi & Misi</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Visi</small>
                    <p class="mb-0">{{ optional($koperasi)->visi ?: '-' }}</p>
                </div>
                <div>
                    <small class="text-muted d-block">Misi</small>
                    <p class="mb-0">{{ optional($koperasi)->misi ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('koperasi.edit') }}" class="btn btn-warning mt-3">
    <i class="fas fa-edit mr-1"></i>Edit Profil Koperasi
</a>
@endsection
