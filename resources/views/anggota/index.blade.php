@extends('layouts.app')

@section('title', 'Data Petani')
@section('page-title', 'Data Petani / Anggota Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Data Petani</li>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header card-header-porang d-flex flex-wrap align-items-center gap-2">
        <h3 class="card-title mb-0"><i class="fas fa-users me-2"></i> Daftar Anggota / Petani</h3>
        <div class="ml-auto d-flex gap-2">
            <a href="{{ route('anggota.create') }}" class="btn btn-light btn-sm">
                <i class="fas fa-plus"></i> Tambah Anggota
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4 col-sm-6">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama, NIK, nomor anggota..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 col-sm-6">
                <select name="status" class="form-control form-control-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status')=='aktif' ? 'selected':'' }}>Aktif</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected':'' }}>Pending</option>
                    <option value="non-aktif" {{ request('status')=='non-aktif' ? 'selected':'' }}>Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-6">
                <select name="jenis" class="form-control form-control-sm">
                    <option value="">Semua Jenis</option>
                    <option value="personal" {{ request('jenis')=='personal' ? 'selected':'' }}>Personal</option>
                    <option value="bumdes" {{ request('jenis')=='bumdes' ? 'selected':'' }}>BUMDes</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-6">
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
            @if(request()->hasAny(['search','status','jenis']))
            <div class="col-md-2 col-sm-6">
                <a href="{{ route('anggota.index') }}" class="btn btn-secondary btn-sm btn-block">Reset</a>
            </div>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>Jenis</th>
                        <th>Asal Daerah</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Tgl Daftar</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $a)
                    <tr>
                        <td><a href="{{ route('anggota.show', $a) }}" class="font-weight-bold text-primary">{{ $a->nomor_anggota }}</a></td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($a->foto_diri)
                                    <img src="{{ asset('storage/'.$a->foto_diri) }}" class="img-circle mr-2" style="width:30px;height:30px;object-fit:cover;">
                                @else
                                    <span class="mr-2"><i class="fas fa-user-circle fa-lg text-secondary"></i></span>
                                @endif
                                {{ $a->nama_lengkap }}
                            </div>
                        </td>
                        <td><code>{{ $a->nik }}</code></td>
                        <td>
                            <span class="badge badge-{{ $a->jenis_anggota === 'bumdes' ? 'info' : 'secondary' }}">
                                {{ strtoupper($a->jenis_anggota) }}
                            </span>
                        </td>
                        <td>
                            <small>{{ implode(', ', array_filter([$a->kecamatan_ktp, $a->kabupaten_ktp])) ?: '-' }}</small>
                        </td>
                        <td>{{ $a->telepon ?: '-' }}</td>
                        <td>
                            @if($a->status === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($a->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td><small>{{ $a->tanggal_daftar->format('d/m/Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('anggota.show', $a) }}" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('anggota.edit', $a) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                @if($a->status === 'pending')
                                <form action="{{ route('anggota.approve', $a) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-success" title="Setujui"><i class="fas fa-check"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-users fa-2x mb-2 d-block text-secondary"></i>
                        Belum ada data anggota
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($anggota->hasPages())
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted">Menampilkan {{ $anggota->firstItem() }}–{{ $anggota->lastItem() }} dari {{ $anggota->total() }} data</small>
            {{ $anggota->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
