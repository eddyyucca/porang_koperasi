@extends('layouts.app')

@section('title', 'Detail Lahan')
@section('page-title', 'Detail Data Lahan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('lahan.index') }}">Lahan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Info Lahan</h3></div>
            <div class="card-body">
                <div class="mb-3"><small class="text-muted d-block">Nama Lahan</small><strong>{{ $lahan->nama_lahan }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Luas</small><strong>{{ number_format($lahan->luas_lahan, 2, ',', '.') }} {{ $lahan->satuan_luas }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Konversi Hektar</small><strong>{{ number_format($lahan->luas_hektar, 2, ',', '.') }} ha</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Status Kepemilikan</small><strong>{{ ucfirst($lahan->status_kepemilikan) }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Kondisi Tanah</small><strong>{{ ucfirst($lahan->kondisi_tanah) }}</strong></div>
                <div><small class="text-muted d-block">Dokumen</small>
                    @if($lahan->dokumen_file)
                        <a href="{{ asset('storage/' . $lahan->dokumen_file) }}" target="_blank">{{ $lahan->jenis_dokumen ?: 'Lihat dokumen' }}</a>
                    @else
                        <strong>-</strong>
                    @endif
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Pemilik</h3></div>
            <div class="card-body">
                @if($lahan->pemilik_type === 'bumdes' && $lahan->bumdes)
                    <div class="mb-2">
                        <span class="badge badge-success mb-1">Lahan Desa / BUMDes</span>
                    </div>
                    <div class="mb-2"><small class="text-muted d-block">BUMDes</small><a href="{{ route('bumdes.show', $lahan->bumdes) }}"><strong>{{ $lahan->bumdes->nama }}</strong></a></div>
                    <div><small class="text-muted d-block">Desa</small><strong>{{ $lahan->bumdes->desa_nama ?: '-' }}</strong></div>
                @else
                    <div class="mb-2">
                        <span class="badge badge-primary mb-1">Petani / Anggota</span>
                    </div>
                    <div class="mb-2"><small class="text-muted d-block">Nama</small><a href="{{ route('anggota.show', $lahan->anggota) }}"><strong>{{ $lahan->anggota->nama_lengkap }}</strong></a></div>
                    <div><small class="text-muted d-block">Nomor Anggota</small><strong>{{ $lahan->anggota->nomor_anggota }}</strong></div>
                @endif
            </div>
        </div>

        <div class="d-flex flex-wrap mb-3">
            @php
                $tanamanCreateParams = $lahan->pemilik_type === 'bumdes'
                    ? ['lahan_id' => $lahan->id]
                    : ['anggota_id' => $lahan->anggota_id, 'lahan_id' => $lahan->id];
            @endphp
            <a href="{{ route('tanaman.create', $tanamanCreateParams) }}" class="btn btn-success mr-2 mb-2">
                <i class="fas fa-plus mr-1"></i>Tambah Tanaman
            </a>
            <a href="{{ route('lahan.edit', $lahan) }}" class="btn btn-warning mr-2 mb-2">
                <i class="fas fa-edit mr-1"></i>Edit Lahan
            </a>
            <form action="{{ route('lahan.destroy', $lahan) }}" method="POST" class="mb-2" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash mr-1"></i>Hapus</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Lokasi</h3></div>
            <div class="card-body">
                <p>{{ $lahan->alamat_lahan ?: '-' }}</p>
                @if($lahan->hasKoordinat())
                    <div id="map-detail-lahan" style="height:300px;"></div>
                @else
                    <div class="alert alert-light border mb-0">Koordinat lahan belum tersedia.</div>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Riwayat Tanaman</h3></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Varietas</th>
                                <th>Tgl Tanam</th>
                                <th>Estimasi Panen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lahan->tanaman as $tanaman)
                                <tr>
                                    <td>{{ $tanaman->varietas }}</td>
                                    <td>{{ optional($tanaman->tanggal_tanam)->format('d/m/Y') }}</td>
                                    <td>{{ optional($tanaman->estimasi_panen)->format('d/m/Y') ?: '-' }}</td>
                                    <td><span class="badge badge-{{ $tanaman->status_badge }}">{{ ucfirst($tanaman->status) }}</span></td>
                                    <td><a href="{{ route('tanaman.show', $tanaman) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada tanaman pada lahan ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                            @forelse($lahan->panen as $panen)
                                <tr>
                                    <td>{{ optional($panen->tanggal_panen)->format('d/m/Y') }}</td>
                                    <td>{{ number_format($panen->berat_panen_kg, 2, ',', '.') }} kg</td>
                                    <td>Rp {{ number_format($panen->total_nilai ?? 0, 0, ',', '.') }}</td>
                                    <td><a href="{{ route('panen.show', $panen) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada panen pada lahan ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($lahan->hasKoordinat())
<script>
const detailLahanMap = L.map('map-detail-lahan').setView([{{ $lahan->latitude }}, {{ $lahan->longitude }}], 15);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(detailLahanMap);
L.marker([{{ $lahan->latitude }}, {{ $lahan->longitude }}]).addTo(detailLahanMap)
    .bindPopup('{{ $lahan->nama_lahan }}')
    .openPopup();
</script>
@endif
@endpush
