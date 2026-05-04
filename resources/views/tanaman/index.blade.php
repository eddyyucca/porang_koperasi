@extends('layouts.app')

@section('title', 'Data Tanaman')
@section('page-title', 'Data Penanaman Porang')
@section('breadcrumb')
    <li class="breadcrumb-item active">Tanaman</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-porang d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-seedling mr-2"></i>Daftar Penanaman</h3>
        <a href="{{ route('tanaman.create') }}" class="btn btn-light btn-sm"><i class="fas fa-plus mr-1"></i>Tambah</a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row">
            <div class="col-md-3 mb-2">
                <label class="font-weight-bold">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    @foreach(['persiapan','tanam','tumbuh','panen','gagal'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label class="font-weight-bold">Varietas</label>
                <input type="text" name="varietas" class="form-control" value="{{ request('varietas') }}">
            </div>
            <div class="col-md-3 mb-2">
                <label class="font-weight-bold">Cari Petani</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}">
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search mr-1"></i>Cari</button>
                <a href="{{ route('tanaman.index') }}" class="btn btn-secondary">Reset</a>
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
                        <th>Varietas</th>
                        <th>Tgl Tanam</th>
                        <th>Estimasi Panen</th>
                        <th>Sisa Hari</th>
                        <th>Umur</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tanaman as $item)
                        @php
                            $sisaHari = $item->sisa_hari_panen;
                            $rowWarning = !in_array($item->status, ['panen', 'gagal'], true) && !is_null($sisaHari) && $sisaHari <= 30;
                            $badgeHari = is_null($sisaHari) ? 'secondary' : ($sisaHari <= 0 ? 'danger' : ($sisaHari <= 30 ? 'warning' : 'success'));
                        @endphp
                        <tr class="{{ $rowWarning ? 'table-warning' : '' }}">
                            <td><a href="{{ route('anggota.show', $item->anggota) }}">{{ $item->anggota->nama_lengkap ?? '-' }}</a></td>
                            <td><a href="{{ route('lahan.show', $item->lahan) }}">{{ $item->lahan->nama_lahan ?? '-' }}</a></td>
                            <td>{{ $item->varietas }}</td>
                            <td>{{ optional($item->tanggal_tanam)->format('d/m/Y') }}</td>
                            <td>{{ optional($item->estimasi_panen)->format('d/m/Y') ?: '-' }}</td>
                            <td>
                                @if(is_null($sisaHari))
                                    <span class="badge badge-secondary">-</span>
                                @elseif($sisaHari <= 0)
                                    <span class="badge badge-danger">Sudah waktunya!</span>
                                @else
                                    <span class="badge badge-{{ $badgeHari }}">{{ $sisaHari }} hari</span>
                                @endif
                            </td>
                            <td>{{ $item->umur_saat_ini }} bln</td>
                            <td><span class="badge badge-{{ $item->status_badge }}">{{ ucfirst($item->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data penanaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tanaman->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted">Menampilkan {{ $tanaman->firstItem() }}-{{ $tanaman->lastItem() }} dari {{ $tanaman->total() }} data</small>
            {{ $tanaman->links() }}
        </div>
    @endif
</div>
@endsection
