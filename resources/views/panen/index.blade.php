@extends('layouts.app')

@section('title', 'Data Panen')
@section('page-title', 'Data Panen')
@section('breadcrumb')
    <li class="breadcrumb-item active">Panen</li>
@endsection

@section('content')
@php
    $avgHarga = $totalKg > 0 ? ($totalNilai / $totalKg) : 0;
    $pageTotalKg = $panen->sum('berat_panen_kg');
    $pageTotalNilai = $panen->sum('total_nilai');
@endphp
<div class="row">
    <div class="col-md-4 mb-3">
        <div class="info-box info-box-green shadow-sm">
            <span class="info-box-icon"><i class="fas fa-weight-hanging"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Panen</span>
                <span class="info-box-number">{{ number_format($totalKg, 2, ',', '.') }} kg</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="info-box info-box-blue shadow-sm">
            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Nilai</span>
                <span class="info-box-number">Rp {{ number_format($totalNilai, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="info-box info-box-orange shadow-sm">
            <span class="info-box-icon"><i class="fas fa-balance-scale"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Rata-rata Harga/kg</span>
                <span class="info-box-number">Rp {{ number_format($avgHarga, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header card-header-porang d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-shopping-basket mr-2"></i>Riwayat Panen</h3>
        <a href="{{ route('panen.create') }}" class="btn btn-light btn-sm"><i class="fas fa-plus mr-1"></i>Tambah</a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row">
            <div class="col-md-3 mb-2"><label class="font-weight-bold">Cari Petani</label><input type="text" name="search" class="form-control" value="{{ request('search') }}"></div>
            <div class="col-md-2 mb-2">
                <label class="font-weight-bold">Metode Jual</label>
                <select name="metode" class="form-control">
                    <option value="">Semua</option>
                    @foreach(['koperasi','pasar','tengkulak','ekspor','langsung'] as $item)
                        <option value="{{ $item }}" {{ request('metode') === $item ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <label class="font-weight-bold">Bulan</label>
                <input type="number" name="bulan" class="form-control" min="1" max="12" value="{{ request('bulan') }}">
            </div>
            <div class="col-md-1 mb-2">
                <label class="font-weight-bold">Tahun</label>
                <input type="number" name="tahun" class="form-control" value="{{ request('tahun') }}">
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search mr-1"></i>Cari</button>
                <a href="{{ route('panen.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Petani</th>
                        <th>Lahan</th>
                        <th>Tgl Panen</th>
                        <th>Berat</th>
                        <th>Harga/kg</th>
                        <th>Total Nilai</th>
                        <th>Metode Jual</th>
                        <th>Status Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($panen as $item)
                        <tr>
                            <td>{{ $item->anggota->nama_lengkap ?? '-' }}</td>
                            <td>{{ $item->lahan->nama_lahan ?? '-' }}</td>
                            <td>{{ optional($item->tanggal_panen)->format('d/m/Y') }}</td>
                            <td>{{ number_format($item->berat_panen_kg, 2, ',', '.') }} kg</td>
                            <td>Rp {{ number_format($item->harga_per_kg ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->total_nilai ?? 0, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($item->metode_jual) }}</td>
                            <td>{{ ucfirst($item->status_jual) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('panen.show', $item) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('panen.edit', $item) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data panen.</td></tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th>{{ number_format($pageTotalKg, 2, ',', '.') }} kg</th>
                        <th></th>
                        <th>Rp {{ number_format($pageTotalNilai, 0, ',', '.') }}</th>
                        <th colspan="3"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @if($panen->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted">Menampilkan {{ $panen->firstItem() }}-{{ $panen->lastItem() }} dari {{ $panen->total() }} data</small>
            {{ $panen->links() }}
        </div>
    @endif
</div>
@endsection
