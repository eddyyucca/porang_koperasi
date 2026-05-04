@extends('layouts.app')

@section('title', 'Detail Anggota')
@section('page-title', 'Detail Data Anggota')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('anggota.index') }}">Data Petani</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
@php
    $badgeClass = $anggota->status === 'aktif' ? 'success' : ($anggota->status === 'pending' ? 'warning' : 'danger');
    $fotoPlaceholder = 'https://placehold.co/600x400/e9ecef/6c757d?text=Foto+Belum+Tersedia';
    $riwayatTanaman = $anggota->lahan->flatMap(function ($lahan) {
        return $lahan->tanaman->map(function ($tanaman) use ($lahan) {
            $tanaman->setRelation('lahan', $lahan);
            return $tanaman;
        });
    })->sortByDesc('tanggal_tanam');
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-id-card mr-2"></i>Informasi KTP</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">NIK</small>
                        <strong>{{ $anggota->nik }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">Nama Lengkap</small>
                        <strong>{{ $anggota->nama_lengkap }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">TTL</small>
                        <strong>{{ $anggota->tempat_lahir }}, {{ optional($anggota->tanggal_lahir)->format('d M Y') }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">Jenis Kelamin</small>
                        <strong>{{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">Agama</small>
                        <strong>{{ $anggota->agama ?: '-' }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">Pekerjaan</small>
                        <strong>{{ $anggota->pekerjaan_ktp ?: '-' }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">Status Perkawinan</small>
                        <strong>{{ $anggota->status_perkawinan ?: '-' }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">Pendidikan</small>
                        <strong>{{ $anggota->pendidikan ?: '-' }}</strong>
                    </div>
                    <div class="col-md-4 mb-3">
                        <small class="text-muted d-block">Telepon</small>
                        <strong>{{ $anggota->telepon ?: '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-map-marker-alt mr-2"></i>Alamat KTP</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Alamat</small>
                        <strong>{{ $anggota->alamat_ktp }}</strong>
                    </div>
                    <div class="col-md-2 mb-3">
                        <small class="text-muted d-block">RT</small>
                        <strong>{{ $anggota->rt_ktp ?: '-' }}</strong>
                    </div>
                    <div class="col-md-2 mb-3">
                        <small class="text-muted d-block">RW</small>
                        <strong>{{ $anggota->rw_ktp ?: '-' }}</strong>
                    </div>
                    <div class="col-md-2 mb-3">
                        <small class="text-muted d-block">Kode Pos</small>
                        <strong>{{ $anggota->kode_pos_ktp ?: '-' }}</strong>
                    </div>
                    <div class="col-md-3 mb-3">
                        <small class="text-muted d-block">Desa</small>
                        <strong>{{ $anggota->desa_ktp ?: '-' }}</strong>
                    </div>
                    <div class="col-md-3 mb-3">
                        <small class="text-muted d-block">Kecamatan</small>
                        <strong>{{ $anggota->kecamatan_ktp ?: '-' }}</strong>
                    </div>
                    <div class="col-md-3 mb-3">
                        <small class="text-muted d-block">Kabupaten</small>
                        <strong>{{ $anggota->kabupaten_ktp ?: '-' }}</strong>
                    </div>
                    <div class="col-md-3 mb-3">
                        <small class="text-muted d-block">Provinsi</small>
                        <strong>{{ $anggota->provinsi_ktp ?: '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-camera mr-2"></i>Foto Dokumen</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="font-weight-bold d-block">Foto KTP</label>
                    <img src="{{ $anggota->foto_ktp ? asset('storage/' . $anggota->foto_ktp) : $fotoPlaceholder }}"
                        alt="Foto KTP" class="img-fluid rounded border">
                </div>
                <div>
                    <label class="font-weight-bold d-block">Foto Diri</label>
                    <img src="{{ $anggota->foto_diri ? asset('storage/' . $anggota->foto_diri) : $fotoPlaceholder }}"
                        alt="Foto Diri" class="img-fluid rounded border">
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-users mr-2"></i>Keanggotaan</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Nomor Anggota</small>
                    <strong>{{ $anggota->nomor_anggota }}</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Koperasi</small>
                    <strong>{{ $anggota->koperasi->nama ?? '-' }}</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">BUMDes</small>
                    <strong>{{ $anggota->jenis_anggota === 'bumdes' ? ($anggota->bumdes->nama ?? '-') : '-' }}</strong>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Tanggal Daftar</small>
                    <strong>{{ optional($anggota->tanggal_daftar)->format('d M Y') ?: '-' }}</strong>
                </div>
                <div>
                    <small class="text-muted d-block">Status</small>
                    <span class="badge badge-{{ $badgeClass }}">{{ ucfirst($anggota->status) }}</span>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-university mr-2"></i>Rekening</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">No. Rekening</small>
                    <strong>{{ $anggota->no_rekening ?: '-' }}</strong>
                </div>
                <div>
                    <small class="text-muted d-block">Bank</small>
                    <strong>{{ $anggota->nama_bank ?: '-' }}</strong>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap mb-3">
            <a href="{{ route('anggota.edit', $anggota) }}" class="btn btn-warning mr-2 mb-2">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            @if($anggota->status === 'pending')
                <form action="{{ route('anggota.approve', $anggota) }}" method="POST" class="mr-2 mb-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check mr-1"></i>Approve
                    </button>
                </form>
            @endif
            <form action="{{ route('anggota.destroy', $anggota) }}" method="POST" class="mb-2" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash mr-1"></i>Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title"><i class="fas fa-map mr-2"></i>Daftar Lahan</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Nama Lahan</th>
                        <th>Luas</th>
                        <th>Lokasi</th>
                        <th>Status Kepemilikan</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota->lahan as $lahan)
                        <tr>
                            <td>{{ $lahan->nama_lahan }}</td>
                            <td>{{ number_format($lahan->luas_lahan, 2, ',', '.') }} {{ $lahan->satuan_luas }}</td>
                            <td>{{ $lahan->lokasi ?: '-' }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($lahan->status_kepemilikan) }}</span></td>
                            <td>
                                <a href="{{ route('lahan.show', $lahan) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data lahan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title"><i class="fas fa-seedling mr-2"></i>Riwayat Tanaman</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Varietas</th>
                        <th>Lahan</th>
                        <th>Tgl Tanam</th>
                        <th>Estimasi Panen</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatTanaman as $tanaman)
                        <tr>
                            <td>{{ $tanaman->varietas }}</td>
                            <td>
                                <a href="{{ route('lahan.show', $tanaman->lahan) }}">{{ $tanaman->lahan->nama_lahan ?? '-' }}</a>
                            </td>
                            <td>{{ optional($tanaman->tanggal_tanam)->format('d/m/Y') }}</td>
                            <td>{{ optional($tanaman->estimasi_panen)->format('d/m/Y') ?: '-' }}</td>
                            <td><span class="badge badge-{{ $tanaman->status_badge }}">{{ ucfirst($tanaman->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat tanaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header card-header-porang">
        <h3 class="card-title"><i class="fas fa-shopping-basket mr-2"></i>Riwayat Panen</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Tgl Panen</th>
                        <th>Lahan</th>
                        <th>Berat</th>
                        <th>Kualitas</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota->panen as $panen)
                        <tr>
                            <td>{{ optional($panen->tanggal_panen)->format('d/m/Y') }}</td>
                            <td>
                                @if($panen->lahan)
                                    <a href="{{ route('lahan.show', $panen->lahan) }}">{{ $panen->lahan->nama_lahan }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ number_format($panen->berat_panen_kg, 2, ',', '.') }} kg</td>
                            <td><span class="badge badge-{{ $panen->kualitas_badge }}">{{ $panen->kualitas }}</span></td>
                            <td>Rp {{ number_format($panen->total_nilai ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat panen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
