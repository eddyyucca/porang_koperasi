@extends('layouts.app')

@section('title', 'Data BUMDes')
@section('page-title', 'Data BUMDes')
@section('breadcrumb')
    <li class="breadcrumb-item active">BUMDes</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-porang d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-landmark mr-2"></i>Daftar BUMDes</h3>
        <a href="{{ route('bumdes.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus mr-1"></i>Tambah
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row">
            <div class="col-md-9 mb-2">
                <label class="font-weight-bold">Pencarian Nama / Kabupaten</label>
                <input type="text" name="search" class="form-control" placeholder="Cari nama BUMDes atau kabupaten" value="{{ request('search') }}">
            </div>
            <div class="col-md-3 mb-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search mr-1"></i>Cari</button>
                <a href="{{ route('bumdes.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama BUMDes</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Direktur</th>
                        <th>Jml Lahan</th>
                        <th>Status</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bumdes as $item)
                        <tr>
                            <td>{{ $bumdes->firstItem() + $loop->index }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kabupaten_nama ?: '-' }}</td>
                            <td>{{ $item->kecamatan_nama ?: '-' }}</td>
                            <td>{{ $item->desa_nama ?: '-' }}</td>
                            <td>{{ $item->direktur ?: '-' }}</td>
                            <td>{{ number_format($item->lahan_count) }}</td>
                            <td>
                                <span class="badge badge-{{ $item->aktif ? 'success' : 'danger' }}">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('bumdes.show', $item) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('bumdes.edit', $item) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('bumdes.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada data BUMDes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($bumdes->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted">Menampilkan {{ $bumdes->firstItem() }}-{{ $bumdes->lastItem() }} dari {{ $bumdes->total() }} data</small>
            {{ $bumdes->links() }}
        </div>
    @endif
</div>
@endsection
