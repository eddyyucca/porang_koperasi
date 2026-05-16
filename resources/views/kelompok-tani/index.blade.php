@extends('layouts.app')

@section('title', 'Kelompok Tani')
@section('page-title', 'Data Kelompok Tani')
@section('breadcrumb')
    <li class="breadcrumb-item active">Kelompok Tani</li>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header card-header-porang d-flex flex-wrap align-items-center gap-2">
        <h3 class="card-title mb-0"><i class="fas fa-people-group me-2"></i> Daftar Kelompok Tani</h3>
        <div class="ml-auto d-flex gap-2">
            <a href="{{ route('kelompok-tani.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Kelompok
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4 col-sm-6">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama kelompok, ketua, kabupaten..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6">
                <select name="status" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif"   {{ request('status')=='aktif'   ? 'selected':'' }}>Aktif</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected':'' }}>Pending</option>
                    <option value="ditolak" {{ request('status')=='ditolak' ? 'selected':'' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-6">
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
            @if(request()->hasAny(['search','status']))
            <div class="col-md-2 col-sm-6">
                <a href="{{ route('kelompok-tani.index') }}" class="btn btn-secondary btn-sm btn-block">Reset</a>
            </div>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Kelompok</th>
                        <th>Ketua</th>
                        <th>Wilayah</th>
                        <th>Anggota</th>
                        <th>BUMDes</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelompokTani as $kt)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('kelompok-tani.show', $kt) }}" class="font-weight-bold text-primary">
                                {{ $kt->nama_kelompok }}
                            </a>
                            @if($kt->nomor_sk)
                                <br><small class="text-muted">SK: {{ $kt->nomor_sk }}</small>
                            @endif
                        </td>
                        <td>
                            {{ $kt->ketua_nama }}
                            @if($kt->ketua_telepon)
                                <br><small class="text-muted">{{ $kt->ketua_telepon }}</small>
                            @endif
                        </td>
                        <td>
                            <small>
                                @php
                                    $parts = array_filter([$kt->desa_nama, $kt->kecamatan_nama, $kt->kabupaten_nama]);
                                @endphp
                                {{ implode(', ', $parts) ?: '-' }}
                            </small>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ $kt->anggota_count ?? $kt->anggota->count() }}</span>
                        </td>
                        <td>{{ $kt->bumdes->nama ?? '-' }}</td>
                        <td>
                            @if($kt->status === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($kt->status === 'pending')
                                <span class="badge badge-warning text-dark">Pending</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kelompok-tani.show', $kt) }}" class="btn btn-xs btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('kelompok-tani.edit', $kt) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('kelompok-tani.destroy', $kt) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kelompok tani ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-people-group fa-2x mb-2 d-block"></i>
                            Belum ada data kelompok tani
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($kelompokTani->hasPages())
    <div class="card-footer">
        {{ $kelompokTani->links() }}
    </div>
    @endif
</div>
@endsection
