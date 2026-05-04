@extends('layouts.app')

@section('title', 'Data Lahan')
@section('page-title', 'Data Lahan')
@section('breadcrumb')
    <li class="breadcrumb-item active">Lahan</li>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header card-header-porang d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-map-marked-alt mr-2"></i>Peta Sebaran Lahan</h3>
        <a href="{{ route('lahan.create') }}" class="btn btn-light btn-sm"><i class="fas fa-plus mr-1"></i>Tambah</a>
    </div>
    <div class="card-body p-0">
        <div id="map-lahan" style="height:300px;"></div>
    </div>
</div>

<div class="card">
    <div class="card-header card-header-porang">
        <h3 class="card-title"><i class="fas fa-table mr-2"></i>Daftar Lahan</h3>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row">
            <div class="col-md-4 mb-2">
                <label class="font-weight-bold">Pencarian</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari nama lahan atau petani">
            </div>
            <div class="col-md-4 mb-2">
                <label class="font-weight-bold">Kabupaten</label>
                <input type="text" name="kabupaten" class="form-control" value="{{ request('kabupaten') }}">
            </div>
            <div class="col-md-2 mb-2">
                <label class="font-weight-bold">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua</option>
                    @foreach(['milik sendiri','sewa','gadai','pinjam'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search mr-1"></i>Cari</button>
                <a href="{{ route('lahan.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Nama Lahan</th>
                        <th>Petani</th>
                        <th>Luas</th>
                        <th>Desa</th>
                        <th>Kabupaten</th>
                        <th>Status Kepemilikan</th>
                        <th>Koordinat</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lahan as $item)
                        <tr>
                            <td>{{ $item->nama_lahan }}</td>
                            <td>{{ $item->anggota->nama_lengkap ?? '-' }}</td>
                            <td>{{ number_format($item->luas_lahan, 2, ',', '.') }} {{ $item->satuan_luas }}</td>
                            <td>{{ $item->desa_nama ?: '-' }}</td>
                            <td>{{ $item->kabupaten_nama ?: '-' }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($item->status_kepemilikan) }}</span></td>
                            <td>
                                @if($item->hasKoordinat())
                                    <i class="fas fa-check-circle text-success" title="Ada koordinat"></i>
                                @else
                                    <i class="fas fa-times-circle text-muted" title="Tidak ada koordinat"></i>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('lahan.show', $item) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('lahan.edit', $item) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data lahan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($lahan->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted">Menampilkan {{ $lahan->firstItem() }}-{{ $lahan->lastItem() }} dari {{ $lahan->total() }} data</small>
            {{ $lahan->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
const lahanMapData = @json($lahanPeta);
const lahanMap = L.map('map-lahan').setView([-2.5, 118], 5);
const lahanShowBaseUrl = @json(url('/lahan'));

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(lahanMap);

const iconLahan = L.divIcon({
    html: '<i class="fas fa-map-marker-alt" style="color:#2e7d32;font-size:24px;"></i>',
    iconSize: [24, 32],
    iconAnchor: [12, 32],
    className: 'leaflet-div-icon-clean'
});

const bounds = [];
lahanMapData.forEach(function(item) {
    if (!item.latitude || !item.longitude) {
        return;
    }

    const marker = L.marker([item.latitude, item.longitude], { icon: iconLahan }).addTo(lahanMap);
    bounds.push([item.latitude, item.longitude]);
    marker.bindPopup(
        '<strong>' + item.nama_lahan + '</strong><br>' +
        'Petani: ' + (item.anggota ? item.anggota.nama_lengkap : '-') + '<br>' +
        'Luas: ' + Number(item.luas_lahan).toLocaleString('id-ID') + ' ' + item.satuan_luas + '<br>' +
        '<a href="' + lahanShowBaseUrl + '/' + item.id + '" class="btn btn-xs btn-success mt-2">Detail</a>'
    );
});

if (bounds.length) {
    lahanMap.fitBounds(bounds, { padding: [20, 20] });
}
</script>
@endpush
