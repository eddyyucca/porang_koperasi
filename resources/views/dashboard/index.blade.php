@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
@php
    $dashboardLahanUrl = url('/lahan');
@endphp

<div class="row">
    <div class="col-xl-3 col-md-6 col-12 mb-3">
        <div class="info-box info-box-green shadow-sm">
            <span class="info-box-icon"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Petani Aktif</span>
                <span class="info-box-number">{{ number_format($stats['total_anggota']) }}</span>
                @if($stats['pending'] > 0)
                    <span class="progress-description">
                        <a href="{{ route('anggota.index', ['status' => 'pending']) }}" class="text-white">
                            <i class="fas fa-clock mr-1"></i>{{ $stats['pending'] }} menunggu approval
                        </a>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12 mb-3">
        <div class="info-box info-box-blue shadow-sm">
            <span class="info-box-icon"><i class="fas fa-map-marked-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Lahan</span>
                <span class="info-box-number">{{ number_format($stats['total_lahan']) }} petak</span>
                <span class="progress-description">{{ number_format($stats['luas_total_ha'], 2, ',', '.') }} Ha total</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12 mb-3">
        <div class="info-box info-box-orange shadow-sm">
            <span class="info-box-icon"><i class="fas fa-seedling"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Sedang Ditanam</span>
                <span class="info-box-number">{{ number_format($stats['total_tanam']) }} plot</span>
                <span class="progress-description">Tanaman aktif</span>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-12 mb-3">
        <div class="info-box info-box-purple shadow-sm">
            <span class="info-box-icon"><i class="fas fa-shopping-basket"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Panen</span>
                <span class="info-box-number">{{ number_format($stats['total_panen_kg'], 0, ',', '.') }} Kg</span>
                <span class="progress-description">Rp {{ number_format($stats['nilai_panen'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row" id="peta">
    <div class="col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-globe-asia mr-2"></i>Peta Sebaran Lahan Petani</h3>
                <span class="badge badge-light text-dark">
                    <i class="fas fa-map-marker-alt text-danger mr-1"></i>{{ $lahanPeta->count() }} titik lahan
                </span>
            </div>
            <div class="card-body p-0">
                <div id="map-dashboard"></div>
            </div>
            <div class="card-footer text-sm text-muted">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="mb-1 mb-md-0">
                        <i class="fas fa-info-circle mr-1"></i>Klik marker untuk melihat detail lahan. Data tanpa koordinat tidak ditampilkan.
                    </div>
                    <div>
                        <span class="badge badge-light border mr-2"><i class="fas fa-circle text-primary mr-1"></i>Lahan Petani</span>
                        <span class="badge badge-light border"><i class="fas fa-circle text-success mr-1"></i>Lahan Desa (BUMDes)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-12 mb-3">
        <div class="card shadow-sm dashboard-chart-card h-100">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Produksi Panen 12 Bulan Terakhir</h3>
            </div>
            <div class="card-body">
                <div class="chart-box">
                    <canvas id="chartPanen"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-12 mb-3">
        <div class="card shadow-sm dashboard-chart-card h-100">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Status Tanaman</h3>
            </div>
            <div class="card-body">
                <div class="chart-box chart-box-sm">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-12 mb-3">
        <div class="card shadow-sm dashboard-chart-card h-100">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Sebaran Petani per Kabupaten</h3>
            </div>
            <div class="card-body">
                <div class="chart-box chart-box-sm">
                    <canvas id="chartKabupaten"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-12 mb-3">
        <div class="card shadow-sm dashboard-table-card h-100">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>Anggota Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Tgl Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggotaTerbaru as $a)
                                <tr>
                                    <td><a href="{{ route('anggota.show', $a) }}" class="text-primary">{{ $a->nomor_anggota }}</a></td>
                                    <td>{{ $a->nama_lengkap }}</td>
                                    <td>
                                        <span class="badge badge-{{ $a->status === 'aktif' ? 'success' : ($a->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($a->status) }}
                                        </span>
                                    </td>
                                    <td>{{ optional($a->tanggal_daftar)->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12 mb-3">
        <div class="card shadow-sm dashboard-table-card h-100">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-shopping-basket mr-2"></i>Panen Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('panen.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Petani</th>
                                <th>Lahan</th>
                                <th>Kg</th>
                                <th>Tgl Panen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($panenTerbaru as $p)
                                <tr>
                                    <td>{{ $p->anggota->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $p->lahan->nama_lahan ?? '-' }}</td>
                                    <td><strong>{{ number_format($p->berat_panen_kg, 0, ',', '.') }}</strong></td>
                                    <td>{{ optional($p->tanggal_panen)->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada data</td>
                                </tr>
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
<script>
const lahanShowBaseUrl = @json($dashboardLahanUrl);
const lahanData = @json($lahanPeta);
const panenData = @json($panenBulanan);
const statusData = @json($statusTanaman);
const kabData = @json($sebaranKabupaten);

const map = L.map('map-dashboard').setView([-2.5, 118], 5);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 18
}).addTo(map);

const markerLayer = L.layerGroup().addTo(map);
const mapBounds = [];

lahanData.forEach(function(lahan) {
    const isBumdes = lahan.pemilik_type === 'bumdes';
    const pemilikNama = isBumdes ? (lahan.bumdes ? lahan.bumdes.nama : '-') : (lahan.anggota ? lahan.anggota.nama_lengkap : '-');
    const marker = L.circleMarker([lahan.latitude, lahan.longitude], {
        radius: isBumdes ? 10 : 8,
        color: isBumdes ? '#2e7d32' : '#0d6efd',
        weight: 2,
        fillColor: isBumdes ? '#6cc070' : '#5aa2ff',
        fillOpacity: 0.9
    }).addTo(markerLayer);
    mapBounds.push([lahan.latitude, lahan.longitude]);
    marker.bindPopup(
        '<div style="min-width:180px;">' +
            '<strong><i class="fas fa-map-marked-alt mr-1" style="color:' + (isBumdes ? '#2e7d32' : '#0d6efd') + ';"></i>' + lahan.nama_lahan + '</strong><br>' +
            '<small class="text-muted">' + (lahan.desa_nama || '-') + ', ' + (lahan.kabupaten_nama || '-') + '</small><br>' +
            '<hr style="margin:6px 0;">' +
            '<small><b>' + (isBumdes ? 'BUMDes' : 'Petani') + ':</b> ' + pemilikNama + '</small><br>' +
            '<small><b>Status lahan:</b> ' + (lahan.status_kepemilikan || '-') + '</small><br>' +
            '<small><b>Luas:</b> ' + Number(lahan.luas_lahan || 0).toLocaleString('id-ID') + ' ' + lahan.satuan_luas + '</small><br>' +
            '<a href="' + lahanShowBaseUrl + '/' + lahan.id + '" class="btn btn-xs btn-success mt-2">Detail</a>' +
        '</div>'
    );
});

if (mapBounds.length > 0) {
    map.fitBounds(mapBounds, { padding: [30, 30] });
}

function renderEmptyState(canvasId, message) {
    const canvas = document.getElementById(canvasId);
    if (!canvas || !canvas.parentElement) {
        return;
    }

    canvas.parentElement.innerHTML =
        '<div class="chart-empty"><div><i class="fas fa-chart-bar fa-2x mb-3 d-block"></i>' + message + '</div></div>';
}

function createChartSafely(canvasId, hasData, config, emptyMessage) {
    if (!hasData) {
        renderEmptyState(canvasId, emptyMessage);
        return;
    }

    const canvas = document.getElementById(canvasId);
    if (!canvas) {
        return;
    }

    new Chart(canvas, config);
}

const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
const labelsChart = panenData.map(function(item) {
    return bulanLabels[Number(item.bulan) - 1] + ' ' + item.tahun;
});

createChartSafely('chartPanen', panenData.length > 0, {
    type: 'bar',
    data: {
        labels: labelsChart,
        datasets: [
            {
                label: 'Berat (Kg)',
                data: panenData.map((item) => Number(item.total_kg || 0)),
                backgroundColor: 'rgba(46,125,50,0.78)',
                borderRadius: 10,
                borderSkipped: false,
                yAxisID: 'yKg'
            },
            {
                label: 'Nilai (Rp)',
                data: panenData.map((item) => Number(item.total_nilai || 0)),
                type: 'line',
                borderColor: '#ff9800',
                backgroundColor: 'rgba(255,152,0,0.12)',
                fill: true,
                yAxisID: 'yNilai',
                tension: 0.35,
                pointRadius: 3,
                pointHoverRadius: 4
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { position: 'top', align: 'start' }
        },
        scales: {
            x: {
                grid: { display: false }
            },
            yKg: {
                type: 'linear',
                position: 'left',
                beginAtZero: true,
                title: { display: true, text: 'Kg' }
            },
            yNilai: {
                type: 'linear',
                position: 'right',
                beginAtZero: true,
                title: { display: true, text: 'Nilai (Rp)' },
                grid: { drawOnChartArea: false }
            }
        }
    }
}, 'Belum ada data panen bulanan untuk ditampilkan.');

const statusColors = {
    persiapan: '#9e9e9e',
    tanam: '#1976d2',
    tumbuh: '#388e3c',
    panen: '#f57f17',
    gagal: '#c62828'
};

createChartSafely('chartStatus', statusData.length > 0, {
    type: 'doughnut',
    data: {
        labels: statusData.map((item) => item.status.charAt(0).toUpperCase() + item.status.slice(1)),
        datasets: [{
            data: statusData.map((item) => Number(item.total || 0)),
            backgroundColor: statusData.map((item) => statusColors[item.status] || '#9e9e9e'),
            borderWidth: 0
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        },
        cutout: '62%'
    }
}, 'Belum ada data status tanaman.');

createChartSafely('chartKabupaten', kabData.length > 0, {
    type: 'bar',
    data: {
        labels: kabData.map((item) => item.kabupaten_ktp || 'Tidak Diketahui'),
        datasets: [{
            label: 'Jumlah Petani',
            data: kabData.map((item) => Number(item.total || 0)),
            backgroundColor: '#2e7d32',
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        maintainAspectRatio: false,
        indexAxis: 'y',
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: {
                beginAtZero: true,
                ticks: { precision: 0 }
            },
            y: {
                grid: { display: false }
            }
        }
    }
}, 'Belum ada data sebaran kabupaten.');

</script>
@endpush
