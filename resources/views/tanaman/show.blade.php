@extends('layouts.app')

@section('title', 'Detail Tanaman')
@section('page-title', 'Detail Data Penanaman')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tanaman.index') }}">Tanaman</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
@php
    $progress = min(100, round(($tanaman->umur_saat_ini / 20) * 100));
@endphp
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Info Tanaman</h3></div>
            <div class="card-body">
                <div class="mb-3"><small class="text-muted d-block">Petani</small><a href="{{ route('anggota.show', $tanaman->anggota) }}"><strong>{{ $tanaman->anggota->nama_lengkap }}</strong></a></div>
                <div class="mb-3"><small class="text-muted d-block">Lahan</small><a href="{{ route('lahan.show', $tanaman->lahan) }}"><strong>{{ $tanaman->lahan->nama_lahan }}</strong></a></div>
                <div class="mb-3"><small class="text-muted d-block">Varietas</small><strong>{{ $tanaman->varietas }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Sumber Bibit</small><strong>{{ $tanaman->sumber_bibit }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Jumlah Bibit</small><strong>{{ number_format($tanaman->jumlah_bibit) }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Luas Tanam</small><strong>{{ $tanaman->luas_tanam ?: '-' }}</strong></div>
                <div><small class="text-muted d-block">Jarak Tanam</small><strong>{{ $tanaman->jarak_tanam ?: '-' }}</strong></div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Kondisi</h3></div>
            <div class="card-body">
                <div class="mb-3"><small class="text-muted d-block">Pupuk</small><strong>{{ $tanaman->pupuk_digunakan ?: '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Pestisida</small><strong>{{ $tanaman->pestisida_digunakan ?: '-' }}</strong></div>
                <div><small class="text-muted d-block">Kendala</small><strong>{{ $tanaman->kendala ?: '-' }}</strong></div>
            </div>
        </div>

        <div class="d-flex flex-wrap mb-3">
            <a href="{{ route('panen.create', ['anggota_id' => $tanaman->anggota_id, 'tanaman_id' => $tanaman->id]) }}" class="btn btn-success mr-2 mb-2">
                <i class="fas fa-plus mr-1"></i>Catat Panen
            </a>
            <a href="{{ route('tanaman.edit', $tanaman) }}" class="btn btn-warning mr-2 mb-2">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            <form action="{{ route('tanaman.destroy', $tanaman) }}" method="POST" class="mb-2" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i>Hapus</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Timeline</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Tanggal Tanam</small><strong>{{ optional($tanaman->tanggal_tanam)->format('d M Y') }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Estimasi Panen</small><strong>{{ optional($tanaman->estimasi_panen)->format('d M Y') ?: '-' }}</strong></div>
                    <div class="col-md-4 mb-3"><small class="text-muted d-block">Tanggal Panen Aktual</small><strong>{{ optional($tanaman->tanggal_panen_aktual)->format('d M Y') ?: '-' }}</strong></div>
                </div>
                <label class="font-weight-bold">Progress Umur Tanaman</label>
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%">{{ $progress }}%</div>
                </div>
                <small class="text-muted">Umur {{ $tanaman->umur_saat_ini }} bulan dari estimasi 20 bulan</small>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Foto Tanaman</h3></div>
            <div class="card-body">
                @if($tanaman->foto)
                    <img src="{{ asset('storage/' . $tanaman->foto) }}" alt="Foto Tanaman" class="img-fluid rounded border">
                @else
                    <div class="alert alert-light border mb-0">Foto tanaman belum tersedia.</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header-porang"><h3 class="card-title">Riwayat Panen</h3></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Tgl Panen</th>
                                <th>Berat</th>
                                <th>Kualitas</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tanaman->panen as $panen)
                                <tr>
                                    <td>{{ optional($panen->tanggal_panen)->format('d/m/Y') }}</td>
                                    <td>{{ number_format($panen->berat_panen_kg, 2, ',', '.') }} kg</td>
                                    <td><span class="badge badge-{{ $panen->kualitas_badge }}">{{ $panen->kualitas }}</span></td>
                                    <td>Rp {{ number_format($panen->total_nilai ?? 0, 0, ',', '.') }}</td>
                                    <td><a href="{{ route('panen.show', $panen) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data panen dari tanaman ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
