@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Statistik Utama --}}
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
        <div class="info-box info-box-green shadow-sm">
            <span class="info-box-icon"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Petani Aktif</span>
                <span class="info-box-number">{{ number_format($stats['total_anggota']) }}</span>
                @if($stats['pending'] > 0)
                    <span class="progress-description">
                        <a href="{{ route('anggota.index', ['status'=>'pending']) }}" class="text-white">
                            <i class="fas fa-clock"></i> {{ $stats['pending'] }} menunggu approval
                        </a>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
        <div class="info-box info-box-blue shadow-sm">
            <span class="info-box-icon"><i class="fas fa-map-marked-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Lahan</span>
                <span class="info-box-number">{{ number_format($stats['total_lahan']) }} petak</span>
                <span class="progress-description">{{ number_format($stats['luas_total_ha'], 2) }} Ha total</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
        <div class="info-box info-box-orange shadow-sm">
            <span class="info-box-icon"><i class="fas fa-seedling"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Sedang Ditanam</span>
                <span class="info-box-number">{{ number_format($stats['total_tanam']) }} plot</span>
                <span class="progress-description">Tanaman aktif</span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
        <div class="info-box info-box-purple shadow-sm">
            <span class="info-box-icon"><i class="fas fa-shopping-basket"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Panen</span>
                <span class="info-box-number">{{ number_format($stats['total_panen_kg'], 0) }} Kg</span>
                <span class="progress-description">Rp {{ number_format($stats['nilai_panen'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Peta GIS --}}
<div class="row" id="peta">
    <div class="col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-globe-asia me-2"></i> Peta Sebaran Lahan Petani</h3>
                <div>
                    <span class="badge badge-light text-dark">
                        <i class="fas fa-map-marker-alt text-danger"></i>
                        {{ $lahanPeta->count() }} titik lahan
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="map-dashboard"></div>
            </div>
            <div class="card-footer text-sm text-muted">
                <i class="fas fa-info-circle"></i> Klik marker untuk detail lahan. Data lahan tanpa koordinat tidak ditampilkan di peta.
            </div>
        </div>
    </div>
</div>

{{-- Chart Row --}}
<div class="row">
    {{-- Panen Bulanan --}}
    <div class="col-lg-8 col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-line me-2"></i> Produksi Panen 12 Bulan Terakhir</h3>
            </div>
            <div class="card-body">
                <canvas id="chartPanen" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Status Tanaman --}}
    <div class="col-lg-4 col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-pie me-2"></i> Status Tanaman</h3>
            </div>
            <div class="card-body">
                <canvas id="chartStatus" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Sebaran per Kabupaten --}}
    <div class="col-lg-6 col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-bar me-2"></i> Sebaran Petani per Kabupaten</h3>
            </div>
            <div class="card-body">
                <canvas id="chartKabupaten" height="180"></canvas>
            </div>
        </div>
    </div>

    {{-- Kualitas Panen --}}
    <div class="col-lg-6 col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-chart-doughnut me-2"></i> Kualitas Panen</h3>
            </div>
            <div class="card-body">
                <canvas id="chartKualitas" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Terbaru --}}
<div class="row">
    <div class="col-lg-6 col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-user-plus me-2"></i> Anggota Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('anggota.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr><th>Nomor</th><th>Nama</th><th>Status</th><th>Tgl Daftar</th></tr>
                        </thead>
                        <tbody>
                            @forelse($anggotaTerbaru as $a)
                                <tr>
                                    <td><a href="{{ route('anggota.show', $a) }}" class="text-primary">{{ $a->nomor_anggota }}</a></td>
                                    <td>{{ $a->nama_lengkap }}</td>
                                    <td>
                                        <span class="badge badge-{{ $a->status === 'aktif' ? 'success' : ($a->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ $a->status }}
                                        </span>
                                    </td>
                                    <td>{{ $a->tanggal_daftar->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header card-header-porang">
                <h3 class="card-title"><i class="fas fa-shopping-basket me-2"></i> Panen Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('panen.index') }}" class="btn btn-sm btn-light">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light">
                            <tr><th>Petani</th><th>Lahan</th><th>Kg</th><th>Tgl Panen</th></tr>
                        </thead>
                        <tbody>
                            @forelse($panenTerbaru as $p)
                                <tr>
                                    <td>{{ $p->anggota->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $p->lahan->nama_lahan ?? '-' }}</td>
                                    <td><strong>{{ number_format($p->berat_panen_kg) }}</strong></td>
                                    <td>{{ $p->tanggal_panen->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Info Porang --}}
<div class="row">
    <div class="col-12 mb-3">
        <div class="card shadow-sm border-left-success">
            <div class="card-header bg-white">
                <h3 class="card-title text-success"><i class="fas fa-leaf me-2"></i> Tentang Tanaman Porang</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-flask fa-2x text-success mb-2"></i>
                            <h6 class="font-weight-bold">Nama Ilmiah</h6>
                            <p class="text-muted mb-0"><em>Amorphophallus muelleri</em></p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h6 class="font-weight-bold">Umur Panen</h6>
                            <p class="text-muted mb-0">18–24 bulan (perdana)</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-weight-hanging fa-2x text-info mb-2"></i>
                            <h6 class="font-weight-bold">Hasil per Tanaman</h6>
                            <p class="text-muted mb-0">0,5 – 3 kg umbi</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                            <h6 class="font-weight-bold">Harga Pasar</h6>
                            <p class="text-muted mb-0">Rp 3.000 – 8.000/kg (basah)</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold"><i class="fas fa-calendar-alt text-primary me-1"></i> Waktu Tanam Optimal</h6>
                        <p class="text-muted">Awal musim hujan: Oktober – November. Sumber bibit: katak/bulbil, umbi, atau biji.</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="font-weight-bold"><i class="fas fa-star text-warning me-1"></i> Kandungan Utama</h6>
                        <p class="text-muted">Glucomannan tinggi — digunakan untuk industri makanan, farmasi, dan produk ekspor ke Jepang & China.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ============ PETA GIS ============
const map = L.map('map-dashboard').setView([-7.5, 110.5], 7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 18
}).addTo(map);

const lahanData = @json($lahanPeta);
const markers = L.markerClusterGroup ? L.markerClusterGroup() : L.layerGroup();

const iconLahan = L.divIcon({
    html: '<i class="fas fa-map-marker-alt" style="color:#2e7d32;font-size:24px;"></i>',
    iconSize: [24, 32],
    iconAnchor: [12, 32],
    className: 'leaflet-div-icon-clean'
});

lahanData.forEach(function(l) {
    const marker = L.marker([l.latitude, l.longitude], {icon: iconLahan});
    marker.bindPopup(`
        <div style="min-width:180px">
            <strong><i class="fas fa-map-marked-alt text-success"></i> ${l.nama_lahan}</strong><br>
            <small class="text-muted">${l.desa_nama || ''}, ${l.kabupaten_nama || ''}</small><br>
            <hr style="margin:6px 0">
            <small><b>Petani:</b> ${l.anggota ? l.anggota.nama_lengkap : '-'}</small><br>
            <small><b>Luas:</b> ${parseFloat(l.luas_lahan).toLocaleString('id')} ${l.satuan_luas}</small><br>
            <a href="/porang/public/lahan/${l.id}" class="btn btn-xs btn-success mt-2">Detail</a>
        </div>
    `);

    if (markers.addLayer) markers.addLayer(marker);
    else marker.addTo(map);
});

if (markers.addTo) markers.addTo(map);

if (lahanData.length === 0) {
    map.setView([-2.5, 118], 5);
}

// ============ CHART PANEN BULANAN ============
const panenData = @json($panenBulanan);
const bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
const labelsChart = panenData.map(d => bulanLabels[d.bulan - 1] + ' ' + d.tahun);
const kgData = panenData.map(d => parseFloat(d.total_kg));
const nilaiData = panenData.map(d => parseFloat(d.total_nilai));

new Chart(document.getElementById('chartPanen'), {
    type: 'bar',
    data: {
        labels: labelsChart,
        datasets: [
            {
                label: 'Berat (Kg)',
                data: kgData,
                backgroundColor: 'rgba(46,125,50,0.7)',
                borderColor: '#2e7d32',
                borderWidth: 1,
                yAxisID: 'yKg',
            },
            {
                label: 'Nilai (Rp)',
                data: nilaiData,
                type: 'line',
                borderColor: '#ff9800',
                backgroundColor: 'rgba(255,152,0,0.15)',
                fill: true,
                yAxisID: 'yNilai',
                tension: 0.4,
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'top' } },
        scales: {
            yKg: {
                type: 'linear', position: 'left',
                title: { display: true, text: 'Kg' }
            },
            yNilai: {
                type: 'linear', position: 'right',
                title: { display: true, text: 'Nilai (Rp)' },
                grid: { drawOnChartArea: false }
            }
        }
    }
});

// ============ CHART STATUS TANAMAN ============
const statusData = @json($statusTanaman);
const statusColors = {
    'persiapan': '#9e9e9e', 'tanam': '#1976d2',
    'tumbuh': '#388e3c', 'panen': '#f57f17', 'gagal': '#c62828'
};

new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
        labels: statusData.map(d => d.status.charAt(0).toUpperCase() + d.status.slice(1)),
        datasets: [{
            data: statusData.map(d => d.total),
            backgroundColor: statusData.map(d => statusColors[d.status] || '#9e9e9e'),
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
        }
    }
});

// ============ CHART SEBARAN KABUPATEN ============
const kabData = @json($sebaranKabupaten);
new Chart(document.getElementById('chartKabupaten'), {
    type: 'bar',
    data: {
        labels: kabData.map(d => d.kabupaten_ktp || 'Tidak Diketahui'),
        datasets: [{
            label: 'Jumlah Petani',
            data: kabData.map(d => d.total),
            backgroundColor: '#2e7d32',
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});

// ============ CHART KUALITAS ============
const kualitasData = @json($kualitasPanen);
new Chart(document.getElementById('chartKualitas'), {
    type: 'pie',
    data: {
        labels: kualitasData.map(d => d.kualitas),
        datasets: [{
            data: kualitasData.map(d => parseFloat(d.total_kg)),
            backgroundColor: ['#4caf50', '#ffc107', '#9e9e9e'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: {
                callbacks: {
                    label: (ctx) => ` ${ctx.label}: ${parseFloat(ctx.raw).toLocaleString('id')} Kg`
                }
            }
        }
    }
});
</script>
@endpush
