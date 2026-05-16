@extends('layouts.app')

@section('title', 'Detail Tanam')
@section('page-title', 'Siklus Tanam')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tanaman.index') }}">Tanaman</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@push('styles')
<style>
/* ── Status Hero ── */
.hero-status {
    border-radius: 20px;
    padding: 24px 20px 20px;
    color: #fff;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
}
.hero-status::before {
    content: '';
    position: absolute; inset: 0;
    background: rgba(0,0,0,.08);
    border-radius: inherit;
}
.hero-status .overlay { position: relative; z-index: 1; }
.hero-title { font-size: 1.1rem; font-weight: 700; margin: 0 0 4px; }
.hero-sub { font-size: .8rem; opacity: .8; }
.status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.22);
    border: 1px solid rgba(255,255,255,.3);
    border-radius: 50px;
    padding: 5px 14px;
    font-size: .78rem; font-weight: 700;
    backdrop-filter: blur(4px);
}

/* ── Progress Steps ── */
.step-track {
    display: flex; align-items: center;
    gap: 0; overflow-x: auto;
    padding: 16px 0 8px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.step-track::-webkit-scrollbar { display: none; }
.step-item { display: flex; flex-direction: column; align-items: center; min-width: 64px; flex: 1; }
.step-dot {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 700;
    border: 2px solid transparent;
    transition: all .2s;
}
.step-dot.done   { background: #2e7d32; color: #fff; }
.step-dot.active { background: #fff; color: #2e7d32; border-color: #2e7d32; box-shadow: 0 0 0 4px rgba(46,125,50,.15); }
.step-dot.wait   { background: #e9ecef; color: #9aa5b1; }
.step-dot.fail   { background: #c62828; color: #fff; }
.step-label { font-size: .68rem; margin-top: 5px; color: #6c757d; text-align: center; line-height: 1.2; }
.step-label.active { color: #2e7d32; font-weight: 700; }
.step-label.done   { color: #2e7d32; }
.step-connector { flex: 1; height: 3px; background: #dee2e6; margin-bottom: 22px; min-width: 20px; }
.step-connector.done { background: #2e7d32; }

/* ── Aksi Cards ── */
.aksi-card {
    border-radius: 16px;
    padding: 20px 18px;
    text-align: center;
    border: 2px solid transparent;
    transition: transform .15s;
}
.aksi-panen  { background: #e8f5e9; border-color: #4caf50; }
.aksi-tunda  { background: #fffde7; border-color: #ffd54f; }
.aksi-gagal  { background: #fce4ec; border-color: #ef9a9a; }
.aksi-btn {
    width: 100%; padding: 14px;
    border-radius: 12px; font-size: .95rem; font-weight: 700;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: filter .15s;
}
.aksi-btn:hover { filter: brightness(.93); }
.aksi-btn.btn-panen  { background: #2e7d32; color: #fff; }
.aksi-btn.btn-tunda  { background: #f9a825; color: #fff; }
.aksi-btn.btn-gagal  { background: #c62828; color: #fff; }
.aksi-btn.btn-tanam  { background: #1565c0; color: #fff; }

/* ── Stat chips ── */
.stat-chip {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 12px 14px;
    text-align: center;
}
.stat-chip .val { font-size: 1.15rem; font-weight: 800; color: #1b5e20; }
.stat-chip .lbl { font-size: .7rem; color: #6c757d; }

/* ── Countdown ── */
.countdown-box {
    background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
    border: 1.5px solid #a5d6a7;
    border-radius: 14px;
    padding: 16px;
    text-align: center;
    margin-bottom: 1rem;
}
.countdown-num { font-size: 2rem; font-weight: 800; color: #2e7d32; line-height: 1; }
.lock-box {
    background: #fff8e1;
    border: 1.5px solid #ffe082;
    border-radius: 14px;
    padding: 16px;
    text-align: center;
    margin-bottom: 1rem;
}
.lock-num { font-size: 2rem; font-weight: 800; color: #f57f17; line-height: 1; }

/* ── Panen Result ── */
.result-box {
    background: linear-gradient(135deg, #e0f2f1, #e8f5e9);
    border: 2px solid #80cbc4;
    border-radius: 16px;
    padding: 20px;
}
.result-box .big-val { font-size: 1.6rem; font-weight: 800; color: #00695c; }

/* ── Info collapse ── */
.info-toggle {
    background: none; border: 1px solid #dee2e6;
    border-radius: 10px; width: 100%; text-align: left;
    padding: 10px 14px; font-size: .85rem; font-weight: 600;
    color: #495057; display: flex; justify-content: space-between;
    cursor: pointer; margin-bottom: 8px;
}

@media (max-width: 576px) {
    .hero-status { padding: 18px 16px 16px; border-radius: 16px; }
    .hero-title { font-size: 1rem; }
    .aksi-btn { padding: 13px 10px; font-size: .9rem; }
    .result-box .big-val { font-size: 1.3rem; }
}
</style>
@endpush

@section('content')
@php
    use Carbon\Carbon;
    $progress       = min(100, max(0, round(($tanaman->umur_saat_ini / 20) * 100)));
    $sisaBulanLock  = $tanaman->bulanSisaHinggaPanen();
    $bolehPanen     = $tanaman->bisaPanen();
    $sisaHariPanen  = $tanaman->sisa_hari_panen;

    $heroBg = match($tanaman->status) {
        'persiapan'  => 'linear-gradient(135deg,#546e7a,#78909c)',
        'tanam'      => 'linear-gradient(135deg,#1565c0,#1976d2)',
        'tumbuh'     => 'linear-gradient(135deg,#2e7d32,#43a047)',
        'siap_panen' => 'linear-gradient(135deg,#e65100,#f57c00)',
        'panen'      => 'linear-gradient(135deg,#00695c,#00897b)',
        'tunda'      => 'linear-gradient(135deg,#f57f17,#ffa000)',
        'gagal'      => 'linear-gradient(135deg,#b71c1c,#c62828)',
        default      => 'linear-gradient(135deg,#546e7a,#78909c)',
    };

    $stepOrder = ['persiapan'=>0,'tanam'=>1,'tumbuh'=>2,'panen'=>3];
    $curStep   = match($tanaman->status) {
        'persiapan' => 0, 'tanam' => 1, 'tumbuh' => 2,
        'siap_panen' => 2, 'panen' => 3, 'tunda' => 2, 'gagal' => 2,
    };
@endphp

{{-- ═══════ HERO STATUS ═══════ --}}
<div class="hero-status" style="background: {{ $heroBg }};">
    <div class="overlay">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="hero-sub mb-1">
                    <i class="fas fa-user mr-1"></i> {{ $tanaman->anggota->nama_lengkap ?? $tanaman->lahan->bumdes->nama ?? '-' }}
                    <span class="mx-1">·</span>
                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $tanaman->lahan->nama_lahan }}
                </div>
                <div class="hero-title">
                    {{ $tanaman->sumber_bibit }} · {{ $tanaman->lahan->luas_lahan }} {{ $tanaman->lahan->satuan_luas }}
                </div>
                <div class="mt-2">
                    <span class="status-pill">
                        <i class="fas fa-circle" style="font-size:.45rem;"></i>
                        {{ $tanaman->status_label }}
                    </span>
                    @if($tanaman->status === 'tunda')
                        <span class="status-pill ml-1">
                            <i class="fas fa-calendar-alt"></i>
                            Tunda → {{ optional($tanaman->tunda_tanggal_baru)->format('d M Y') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="d-flex flex-column align-items-end" style="gap:6px;">
                <a href="{{ route('tanaman.edit', $tanaman) }}"
                   class="btn btn-sm" style="background:rgba(255,255,255,.2); color:#fff; border-radius:10px; font-size:.78rem;">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="mt-3">
            <div class="d-flex justify-content-between" style="font-size:.72rem; opacity:.8; margin-bottom:4px;">
                <span>Umur tanaman: {{ $tanaman->umur_saat_ini }} bulan</span>
                <span>Target: 20 bulan</span>
            </div>
            <div style="background:rgba(255,255,255,.25); border-radius:50px; height:8px;">
                <div style="background:#fff; border-radius:50px; height:8px; width:{{ $progress }}%; transition:width .4s;"></div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════ STEP TRACKER ═══════ --}}
<div class="card mb-3">
    <div class="card-body py-2 px-3">
        <div class="step-track">
            @php $steps4 = [['Persiapan','box'],['Tanam','seedling'],['Tumbuh','leaf'],['Panen','shopping-basket']]; @endphp
            @foreach($steps4 as $i => [$lbl, $ico])
                @if($i > 0)
                    <div class="step-connector {{ $i <= $curStep ? 'done' : '' }}"></div>
                @endif
                @php
                    $cls = $i < $curStep ? 'done' : ($i === $curStep ? 'active' : 'wait');
                    if ($tanaman->status === 'gagal' && $i === $curStep) $cls = 'fail';
                @endphp
                <div class="step-item">
                    <div class="step-dot {{ $cls }}">
                        @if($i < $curStep) <i class="fas fa-check"></i>
                        @elseif($tanaman->status === 'gagal' && $i === $curStep) <i class="fas fa-times"></i>
                        @else <i class="fas fa-{{ $ico }}"></i>
                        @endif
                    </div>
                    <div class="step-label {{ $cls }}">{{ $lbl }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
{{-- ═══════ KOLOM UTAMA (Aksi) ═══════ --}}
<div class="col-lg-7 col-xl-8">

{{-- ── AKSI LAPANGAN ── --}}
<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title mb-0"><i class="fas fa-hand-pointer mr-2"></i>Aksi Lapangan</h3>
    </div>
    <div class="card-body">

    {{-- PERSIAPAN / BELUM KONFIRMASI TANAM --}}
    @if(in_array($tanaman->status, ['persiapan','tanam']) && !$tanaman->sudahKonfirmasiTanam())
        <div class="text-center py-2">
            <div style="width:72px;height:72px;background:#e8f5e9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <i class="fas fa-seedling fa-2x" style="color:#2e7d32;"></i>
            </div>
            <h5 class="font-weight-bold mb-1">Sudah tanam benihnya?</h5>
            <p class="text-muted small mb-4">Tekan tombol di bawah setelah benih benar-benar sudah ditanam di lahan.</p>
            <form action="{{ route('tanaman.konfirmasi-tanam', $tanaman) }}" method="POST"
                  onsubmit="return confirm('Konfirmasi bahwa benih sudah ditanam di lahan?')">
                @csrf
                <button type="submit" class="aksi-btn btn-tanam" style="max-width:320px;margin:0 auto;">
                    <i class="fas fa-check-circle"></i> Ya, Sudah Ditanam
                </button>
            </form>
        </div>

    {{-- TUMBUH - MASIH LOCKED --}}
    @elseif($tanaman->status === 'tumbuh' && !$bolehPanen && $sisaBulanLock > 0)
        <div class="lock-box">
            <div class="lock-num">{{ $sisaBulanLock }}</div>
            <div style="font-size:.85rem;color:#e65100;font-weight:600;margin:4px 0;">bulan lagi bisa panen</div>
            <div class="text-muted small">
                Tanaman baru berumur <strong>{{ $tanaman->umur_saat_ini }} bulan</strong>.
                Porang membutuhkan minimal <strong>12 bulan</strong> sebelum bisa dipanen.
            </div>
        </div>
        @if($tanaman->estimasi_panen)
        <div class="text-center text-muted small mt-2 mb-3">
            <i class="fas fa-calendar-alt mr-1"></i>
            Estimasi panen: <strong>{{ $tanaman->estimasi_panen->format('d F Y') }}</strong>
            @if($sisaHariPanen !== null && $sisaHariPanen > 0)
                ({{ $sisaHariPanen }} hari lagi)
            @endif
        </div>
        @endif
        {{-- Hanya tombol gagal yang tersedia --}}
        <hr class="my-3">
        <div class="text-center">
            <p class="text-muted small mb-2">Jika terjadi masalah serius pada tanaman:</p>
            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modalGagal">
                <i class="fas fa-times-circle mr-1"></i> Laporkan Gagal
            </button>
        </div>

    {{-- SIAP PANEN / TUNDA / BISA PANEN --}}
    @elseif(in_array($tanaman->status, ['tumbuh','siap_panen','tunda']) && $bolehPanen)

        @if($sisaHariPanen !== null)
        <div class="countdown-box mb-3">
            @if($sisaHariPanen <= 0)
                <div class="countdown-num">🎉</div>
                <div style="font-size:.95rem;font-weight:700;color:#2e7d32;margin:4px 0;">Waktunya Panen!</div>
                <div class="text-muted small">Tanaman sudah melewati estimasi waktu panen.</div>
            @else
                <div class="countdown-num">{{ $sisaHariPanen }}</div>
                <div style="font-size:.85rem;font-weight:600;color:#2e7d32;margin:4px 0;">hari menuju estimasi panen</div>
                <div class="text-muted small">
                    {{ optional($tanaman->tunda_tanggal_baru ?? $tanaman->estimasi_panen)->format('d F Y') }}
                </div>
            @endif
        </div>
        @endif

        <div class="row g-2" style="gap: 10px 0;">
            <div class="col-12 mb-2">
                <div class="aksi-card aksi-panen">
                    <i class="fas fa-shopping-basket fa-lg" style="color:#2e7d32;margin-bottom:8px;"></i>
                    <p class="text-muted small mb-3">Hasil panen sudah dikumpulkan? Masukkan beratnya.</p>
                    <button class="aksi-btn btn-panen" data-toggle="modal" data-target="#modalPanen">
                        <i class="fas fa-check-circle"></i> Konfirmasi Panen
                    </button>
                </div>
            </div>
            <div class="col-6">
                <div class="aksi-card aksi-tunda" style="padding:14px;">
                    <i class="fas fa-clock" style="color:#f9a825;font-size:1.3rem;margin-bottom:6px;"></i>
                    <p class="text-muted" style="font-size:.75rem;margin-bottom:8px;">Belum bisa panen sekarang?</p>
                    <button class="aksi-btn btn-tunda" style="font-size:.82rem;padding:10px;" data-toggle="modal" data-target="#modalTunda">
                        <i class="fas fa-pause-circle"></i> Tunda
                    </button>
                </div>
            </div>
            <div class="col-6">
                <div class="aksi-card aksi-gagal" style="padding:14px;">
                    <i class="fas fa-exclamation-triangle" style="color:#c62828;font-size:1.3rem;margin-bottom:6px;"></i>
                    <p class="text-muted" style="font-size:.75rem;margin-bottom:8px;">Tanaman rusak/gagal?</p>
                    <button class="aksi-btn btn-gagal" style="font-size:.82rem;padding:10px;" data-toggle="modal" data-target="#modalGagal">
                        <i class="fas fa-times-circle"></i> Gagal
                    </button>
                </div>
            </div>
        </div>

    {{-- SUDAH PANEN --}}
    @elseif($tanaman->status === 'panen')
        <div class="result-box">
            <div class="text-center mb-3">
                <span style="font-size:2.5rem;">🎊</span>
                <h5 class="font-weight-bold mt-1 mb-0" style="color:#00695c;">Panen Berhasil!</h5>
                <div class="text-muted small">{{ optional($tanaman->tanggal_panen_aktual)->format('d F Y') }}</div>
            </div>
            <div class="row text-center">
                <div class="col-4">
                    <div class="big-val">{{ number_format($tanaman->berat_panen_kg ?? 0, 0, ',', '.') }}</div>
                    <div class="text-muted" style="font-size:.72rem;">kg dipanen</div>
                </div>
                <div class="col-4">
                    <div class="big-val" style="font-size:1.1rem;">Rp{{ number_format($tanaman->harga_per_kg_panen ?? 0, 0, ',', '.') }}</div>
                    <div class="text-muted" style="font-size:.72rem;">per kg</div>
                </div>
                <div class="col-4">
                    <div class="big-val" style="font-size:1.1rem; color:#1b5e20;">
                        Rp{{ number_format(($tanaman->total_nilai_panen ?? 0) / 1000, 0, ',', '.') }}rb
                    </div>
                    <div class="text-muted" style="font-size:.72rem;">total nilai</div>
                </div>
            </div>
            @if($tanaman->total_nilai_panen)
            <div class="text-center mt-3 pt-3" style="border-top:1px solid #b2dfdb;">
                <div style="font-size:.8rem;color:#00695c;">Total Nilai Panen</div>
                <div style="font-size:1.8rem;font-weight:800;color:#00695c;">
                    Rp {{ number_format($tanaman->total_nilai_panen, 0, ',', '.') }}
                </div>
            </div>
            @endif
        </div>
        <div class="text-muted small text-center mt-2">
            Dikonfirmasi oleh {{ $tanaman->konfirmasiPanenUser->name ?? '-' }}
            · {{ optional($tanaman->konfirmasi_panen_at)->format('d M Y, H:i') }}
        </div>

    {{-- GAGAL --}}
    @elseif($tanaman->status === 'gagal')
        <div class="text-center py-3">
            <div style="width:72px;height:72px;background:#fce4ec;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <i class="fas fa-times fa-2x" style="color:#c62828;"></i>
            </div>
            <h5 class="font-weight-bold text-danger mb-1">Gagal Panen</h5>
            <div class="text-muted small px-2">{{ $tanaman->gagal_alasan }}</div>
        </div>
    @endif

    {{-- Konfirmasi tanam stamp --}}
    @if($tanaman->sudahKonfirmasiTanam())
    <div class="alert alert-success py-2 mb-0 mt-3" style="font-size:.8rem;border-radius:10px;">
        <i class="fas fa-check-circle mr-1"></i>
        Ditanam & dikonfirmasi pada {{ optional($tanaman->konfirmasi_tanam_at)->format('d M Y') }}
        oleh <strong>{{ $tanaman->konfirmasiTanamUser->name ?? '-' }}</strong>
    </div>
    @endif

    {{-- Tunda info --}}
    @if($tanaman->status === 'tunda' && $tanaman->tunda_alasan)
    <div class="alert alert-warning py-2 mt-3 mb-0" style="font-size:.8rem;border-radius:10px;">
        <i class="fas fa-pause-circle mr-1"></i>
        <strong>Ditunda</strong> · {{ $tanaman->tunda_alasan }}
    </div>
    @endif

    </div>
</div>

</div>{{-- end col utama --}}

{{-- ═══════ KOLOM KANAN (Stats + Info) ═══════ --}}
<div class="col-lg-5 col-xl-4">

    {{-- Stat chips --}}
    <div class="row mb-3" style="gap:8px 0;">
        <div class="col-6 mb-2">
            <div class="stat-chip">
                <div class="val">{{ $tanaman->estimasi_batang ? number_format($tanaman->estimasi_batang) : '—' }}</div>
                <div class="lbl"><i class="fas fa-seedling mr-1"></i>Est. Batang</div>
            </div>
        </div>
        <div class="col-6 mb-2">
            <div class="stat-chip">
                <div class="val">{{ $tanaman->umur_saat_ini }}<small style="font-size:.7rem;"> bln</small></div>
                <div class="lbl"><i class="fas fa-calendar mr-1"></i>Umur Tanam</div>
            </div>
        </div>
        <div class="col-6 mb-2">
            <div class="stat-chip">
                @if($hargaAktif)
                    <div class="val" style="font-size:.9rem;">Rp{{ number_format($hargaAktif->harga_per_kg,0,',','.') }}</div>
                    <div class="lbl"><i class="fas fa-tag mr-1"></i>Harga/kg</div>
                @else
                    <div class="val" style="font-size:.85rem;color:#9aa5b1;">—</div>
                    <div class="lbl">Harga belum ada</div>
                @endif
            </div>
        </div>
        <div class="col-6 mb-2">
            <div class="stat-chip">
                @if($tanaman->total_nilai_panen)
                    <div class="val" style="font-size:.85rem;">Rp{{ number_format($tanaman->total_nilai_panen/1000,0,',','.') }}rb</div>
                    <div class="lbl"><i class="fas fa-money-bill-wave mr-1"></i>Nilai Panen</div>
                @else
                    <div class="val" style="color:#9aa5b1;">—</div>
                    <div class="lbl">Belum panen</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Info tanaman (collapsible) --}}
    <div class="card mb-3">
        <div class="card-header card-header-porang py-2 px-3" style="cursor:pointer;" data-toggle="collapse" data-target="#infoTanaman">
            <div class="d-flex justify-content-between align-items-center">
                <span class="card-title mb-0" style="font-size:.88rem;"><i class="fas fa-info-circle mr-2"></i>Info Tanaman</span>
                <i class="fas fa-chevron-down" style="font-size:.75rem;"></i>
            </div>
        </div>
        <div class="collapse show" id="infoTanaman">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between py-1 border-bottom" style="font-size:.82rem;">
                    <span class="text-muted">Sumber Bibit</span>
                    <strong>{{ ucfirst($tanaman->sumber_bibit) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom" style="font-size:.82rem;">
                    <span class="text-muted">Jumlah Bibit</span>
                    <strong>{{ number_format($tanaman->jumlah_bibit) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom" style="font-size:.82rem;">
                    <span class="text-muted">Jarak Tanam</span>
                    <strong>{{ $tanaman->jarak_tanam_x_cm }}×{{ $tanaman->jarak_tanam_y_cm }} cm</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom" style="font-size:.82rem;">
                    <span class="text-muted">Lahan</span>
                    <strong>{{ $tanaman->lahan->luas_lahan }} {{ $tanaman->lahan->satuan_luas }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom" style="font-size:.82rem;">
                    <span class="text-muted">Tanggal Tanam</span>
                    <strong>{{ $tanaman->tanggal_tanam->format('d M Y') }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1" style="font-size:.82rem;">
                    <span class="text-muted">Estimasi Panen</span>
                    <strong>{{ optional($tanaman->estimasi_panen)->format('d M Y') ?: '—' }}</strong>
                </div>
                @if($tanaman->pupuk_digunakan || $tanaman->kendala)
                <hr class="my-2">
                @if($tanaman->pupuk_digunakan)
                <div class="d-flex justify-content-between py-1 border-bottom" style="font-size:.82rem;">
                    <span class="text-muted">Pupuk</span>
                    <strong>{{ $tanaman->pupuk_digunakan }}</strong>
                </div>
                @endif
                @if($tanaman->kendala)
                <div class="py-1" style="font-size:.82rem;">
                    <span class="text-muted d-block">Kendala</span>
                    <span class="text-warning">{{ $tanaman->kendala }}</span>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>

    {{-- Foto --}}
    @if($tanaman->foto)
    <div class="card mb-3">
        <img src="{{ asset('storage/' . $tanaman->foto) }}" alt="Foto" class="card-img-top" style="border-radius:16px;max-height:200px;object-fit:cover;">
    </div>
    @endif

    {{-- Tombol delete --}}
    <form action="{{ route('tanaman.destroy', $tanaman) }}" method="POST"
          onsubmit="return confirm('Hapus data penanaman ini? Tindakan tidak bisa dibatalkan.')" class="mb-3">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm btn-block">
            <i class="fas fa-trash mr-1"></i> Hapus Data Tanam
        </button>
    </form>

</div>
</div>

{{-- ════ MODAL: Konfirmasi Panen ════ --}}
<div class="modal fade" id="modalPanen" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header" style="background:#2e7d32;color:#fff;border:0;">
                <h5 class="modal-title"><i class="fas fa-shopping-basket mr-2"></i>Konfirmasi Panen</h5>
                <button type="button" class="close" style="color:#fff;" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('tanaman.konfirmasi-panen', $tanaman) }}" method="POST">
            @csrf
            <div class="modal-body">
                @if($hargaAktif)
                <div class="text-center p-3 mb-3" style="background:#e8f5e9;border-radius:12px;">
                    <div style="font-size:.75rem;color:#6c757d;">Harga Porang Saat Ini</div>
                    <div style="font-size:1.8rem;font-weight:800;color:#2e7d32;">{{ $hargaAktif->harga_format }}</div>
                    <div style="font-size:.72rem;color:#6c757d;">per kilogram</div>
                </div>
                @else
                <div class="alert alert-warning py-2 mb-3" style="border-radius:10px;">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Harga belum ditetapkan admin. Nilai tidak dihitung otomatis.
                </div>
                @endif

                <div class="mb-3">
                    <label class="font-weight-bold">Berat Panen <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="berat_panen_kg" id="beratPanen"
                            class="form-control form-control-lg" step="0.1" min="0.1"
                            placeholder="0.0" required style="font-size:1.5rem;font-weight:700;text-align:right;">
                        <div class="input-group-append">
                            <span class="input-group-text font-weight-bold">kg</span>
                        </div>
                    </div>
                </div>

                @if($hargaAktif)
                <div id="previewNilai" class="text-center py-2 mb-3" style="background:#f8f9fa;border-radius:10px;display:none;">
                    <div style="font-size:.75rem;color:#6c757d;">Estimasi Nilai</div>
                    <div id="nilaiText" style="font-size:1.4rem;font-weight:800;color:#2e7d32;">Rp 0</div>
                </div>
                @endif

                <div>
                    <label class="font-weight-bold" style="font-size:.85rem;">Catatan <span class="text-muted font-weight-normal">(opsional)</span></label>
                    <textarea name="catatan" class="form-control" rows="2" placeholder="Kondisi panen, dll..."></textarea>
                </div>
            </div>
            <div class="modal-footer" style="border:0; padding-top:0;">
                <button type="button" class="btn btn-light flex-fill" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn flex-fill" style="background:#2e7d32;color:#fff;font-weight:700;">
                    <i class="fas fa-check-circle mr-1"></i> Konfirmasi Panen
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- ════ MODAL: Tunda Panen ════ --}}
<div class="modal fade" id="modalTunda" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header" style="background:#f9a825;border:0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-pause-circle mr-2"></i>Tunda Panen</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('tanaman.tunda-panen', $tanaman) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="font-weight-bold">Jadwal Panen Baru <span class="text-danger">*</span></label>
                    <input type="date" name="tunda_tanggal_baru" class="form-control form-control-lg"
                        min="{{ today()->addDay()->format('Y-m-d') }}" required>
                </div>
                <div>
                    <label class="font-weight-bold">Alasan <span class="text-danger">*</span></label>
                    <textarea name="tunda_alasan" class="form-control" rows="3"
                        placeholder="Kenapa ditunda? (hama, cuaca, dll)" required></textarea>
                </div>
            </div>
            <div class="modal-footer" style="border:0;padding-top:0;">
                <button type="button" class="btn btn-light flex-fill" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn flex-fill" style="background:#f9a825;color:#fff;font-weight:700;">
                    <i class="fas fa-clock mr-1"></i> Tunda Panen
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- ════ MODAL: Gagal Panen ════ --}}
<div class="modal fade" id="modalGagal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;overflow:hidden;">
            <div class="modal-header" style="background:#c62828;color:#fff;border:0;">
                <h5 class="modal-title"><i class="fas fa-times-circle mr-2"></i>Laporkan Gagal Panen</h5>
                <button type="button" class="close" style="color:#fff;" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('tanaman.gagal-panen', $tanaman) }}" method="POST"
                  onsubmit="return confirm('Yakin gagal panen? Status ini tidak bisa diubah kembali.')">
            @csrf
            <div class="modal-body">
                <div class="alert alert-danger py-2 mb-3" style="border-radius:10px;font-size:.82rem;">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Status gagal bersifat final dan tidak dapat diubah kembali.
                </div>
                <div>
                    <label class="font-weight-bold">Penyebab Kegagalan <span class="text-danger">*</span></label>
                    <textarea name="gagal_alasan" class="form-control" rows="3"
                        placeholder="Hama, banjir, kekeringan, penyakit, dll..." required></textarea>
                </div>
            </div>
            <div class="modal-footer" style="border:0;padding-top:0;">
                <button type="button" class="btn btn-light flex-fill" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn flex-fill" style="background:#c62828;color:#fff;font-weight:700;">
                    <i class="fas fa-times mr-1"></i> Konfirmasi Gagal
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
@if($hargaAktif)
const hargaPerKg = {{ $hargaAktif->harga_per_kg }};
document.getElementById('beratPanen')?.addEventListener('input', function() {
    const berat = parseFloat(this.value) || 0;
    const box   = document.getElementById('previewNilai');
    const txt   = document.getElementById('nilaiText');
    if (berat > 0 && box && txt) {
        txt.textContent = 'Rp ' + (berat * hargaPerKg).toLocaleString('id-ID');
        box.style.display = '';
    } else if (box) {
        box.style.display = 'none';
    }
});
@endif
</script>
@endpush
