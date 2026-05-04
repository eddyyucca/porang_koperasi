@extends('layouts.app')

@section('title', 'Detail BUMDes')
@section('page-title', 'Detail BUMDes')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('bumdes.index') }}">BUMDes</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-landmark mr-2"></i>Informasi BUMDes</h3>
            </div>
            <div class="card-body">
                <div class="mb-3"><small class="text-muted d-block">Nama</small><strong>{{ $bumdes->nama }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Nomor SK</small><strong>{{ $bumdes->nomor_sk ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Tanggal SK</small><strong>{{ optional($bumdes->tanggal_sk)->format('d M Y') ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Direktur</small><strong>{{ $bumdes->direktur ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Telepon</small><strong>{{ $bumdes->telepon ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Email</small><strong>{{ $bumdes->email ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Rekening Bank</small><strong>{{ $bumdes->rekening_bank ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Nama Bank</small><strong>{{ $bumdes->nama_bank ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Status</small><span class="badge badge-{{ $bumdes->aktif ? 'success' : 'danger' }}">{{ $bumdes->aktif ? 'Aktif' : 'Nonaktif' }}</span></div>
                <div class="mb-3"><small class="text-muted d-block">Alamat</small><strong>{{ $bumdes->alamat }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Desa</small><strong>{{ $bumdes->desa_nama ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Kecamatan</small><strong>{{ $bumdes->kecamatan_nama ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Kabupaten</small><strong>{{ $bumdes->kabupaten_nama ?: '-' }}</strong></div>
                <div><small class="text-muted d-block">Provinsi</small><strong>{{ $bumdes->provinsi_nama ?: '-' }}</strong></div>
            </div>
        </div>
        <a href="{{ route('bumdes.edit', $bumdes) }}" class="btn btn-warning">
            <i class="fas fa-edit mr-1"></i>Edit
        </a>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-users mr-2"></i>Daftar Anggota BUMDes</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bumdes->anggota as $item)
                                <tr>
                                    <td>{{ $item->nomor_anggota }}</td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->telepon ?: '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->status === 'aktif' ? 'success' : ($item->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td><a href="{{ route('anggota.show', $item) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada anggota terkait.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
