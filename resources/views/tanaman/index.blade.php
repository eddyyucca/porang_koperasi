@extends('layouts.app')

@section('title', 'Data Tanaman')
@section('page-title', 'Data Penanaman Porang')
@section('breadcrumb')
    <li class="breadcrumb-item active">Tanaman</li>
@endsection

@push('styles')
<style>
.tanaman-card {
    border-radius: 14px;
    border: 1px solid #e9ecef;
    padding: 14px 16px;
    margin-bottom: 10px;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
    transition: box-shadow .15s;
    display: block;
    color: inherit;
    text-decoration: none;
}
.tanaman-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); text-decoration: none; color: inherit; }
.tanaman-card.warning { border-left: 4px solid #ffc107; }
.tc-name { font-weight: 700; font-size: .95rem; color: #1b5e20; }
.tc-sub { font-size: .78rem; color: #6c757d; }
.tc-badge { font-size: .7rem; padding: 3px 10px; border-radius: 50px; font-weight: 700; }
.sisa-chip { font-size: .72rem; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 20px; padding: 2px 8px; }
</style>
@endpush

@section('content')

{{-- Filter --}}
<div class="card mb-3">
    <div class="card-body py-2 px-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-6 col-md-4">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">Semua Status</option>
                        @foreach(['persiapan'=>'Persiapan','tanam'=>'Tanam','tumbuh'=>'Tumbuh','siap_panen'=>'Siap Panen','panen'=>'Panen','tunda'=>'Tunda','gagal'=>'Gagal'] as $v=>$l)
                            <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Cari petani / lahan..." value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-search mr-1"></i> Cari
                    </button>
                    @if(request()->hasAny(['status','search']))
                        <a href="{{ route('tanaman.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                    @endif
                    <a href="{{ route('tanaman.create') }}" class="btn btn-success btn-sm flex-fill">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Mobile: Card List --}}
<div class="d-block d-md-none">
    @forelse($tanaman as $item)
    @php
        $sisaHari = $item->sisa_hari_panen;
        $isWarn = !in_array($item->status,['panen','gagal']) && !is_null($sisaHari) && $sisaHari <= 30;
    @endphp
    <a href="{{ route('tanaman.show', $item) }}" class="tanaman-card {{ $isWarn?'warning':'' }}">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="tc-name">{{ $item->anggota->nama_lengkap ?? $item->lahan->bumdes->nama ?? '-' }}</div>
                <div class="tc-sub"><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->lahan->nama_lahan ?? '-' }}</div>
            </div>
            <span class="tc-badge ml-2" style="background:{{ match($item->status){
                'persiapan'=>'#607d8b','tanam'=>'#1565c0','tumbuh'=>'#2e7d32',
                'siap_panen'=>'#e65100','panen'=>'#00695c','tunda'=>'#f57f17','gagal'=>'#c62828',default=>'#607d8b'
            } }};color:#fff;white-space:nowrap;">{{ $item->status_label }}</span>
        </div>
        <div class="mt-2 d-flex flex-wrap" style="gap:6px;">
            <span class="sisa-chip"><i class="fas fa-calendar mr-1"></i>{{ $item->tanggal_tanam->format('d M Y') }}</span>
            @if($item->estimasi_batang)
                <span class="sisa-chip"><i class="fas fa-seedling mr-1"></i>{{ number_format($item->estimasi_batang) }} batang</span>
            @endif
            @if(!is_null($sisaHari) && !in_array($item->status,['panen','gagal']))
                <span class="sisa-chip" style="{{ $sisaHari<=0?'color:#c62828;':($sisaHari<=30?'color:#f57f17;':'') }}">
                    <i class="fas fa-clock mr-1"></i>
                    {{ $sisaHari <= 0 ? 'Sudah waktunya!' : $sisaHari.' hari' }}
                </span>
            @endif
            @if($item->total_nilai_panen)
                <span class="sisa-chip" style="color:#00695c;font-weight:700;">Rp{{ number_format($item->total_nilai_panen/1000,0,',','.')}}rb</span>
            @endif
        </div>
    </a>
    @empty
    <div class="text-center text-muted py-5">
        <i class="fas fa-seedling fa-3x mb-3 d-block" style="opacity:.2;"></i>
        Belum ada data penanaman
    </div>
    @endforelse
</div>

{{-- Desktop: Table --}}
<div class="card d-none d-md-block">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Petani</th>
                        <th>Lahan</th>
                        <th>Tgl Tanam</th>
                        <th>Est. Panen</th>
                        <th class="d-none d-lg-table-cell">Batang</th>
                        <th>Sisa Hari</th>
                        <th class="d-none d-lg-table-cell">Umur</th>
                        <th>Status</th>
                        <th width="50">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tanaman as $item)
                    @php
                        $sisaHari = $item->sisa_hari_panen;
                        $isWarn = !in_array($item->status,['panen','gagal']) && !is_null($sisaHari) && $sisaHari <= 30;
                        $badgeHari = is_null($sisaHari)?'secondary':($sisaHari<=0?'danger':($sisaHari<=30?'warning':'success'));
                    @endphp
                    <tr class="{{ $isWarn?'table-warning':'' }}">
                        <td class="font-weight-bold" style="font-size:.85rem;">
                            @if($item->anggota)
                                <a href="{{ route('anggota.show', $item->anggota) }}">{{ $item->anggota->nama_lengkap }}</a>
                            @else
                                <span class="text-success">{{ $item->lahan->bumdes->nama ?? '-' }}</span>
                                <div><small class="badge badge-success" style="font-size:.65rem;">BUMDes</small></div>
                            @endif
                        </td>
                        <td style="font-size:.85rem;">{{ $item->lahan->nama_lahan??'-' }}</td>
                        <td style="font-size:.82rem;">{{ $item->tanggal_tanam->format('d/m/Y') }}</td>
                        <td style="font-size:.82rem;">{{ optional($item->tunda_tanggal_baru??$item->estimasi_panen)->format('d/m/Y')??'-' }}</td>
                        <td class="text-muted d-none d-lg-table-cell" style="font-size:.8rem;">{{ $item->estimasi_batang?number_format($item->estimasi_batang):'-' }}</td>
                        <td>
                            @if(is_null($sisaHari)) <span class="badge badge-secondary">-</span>
                            @elseif($sisaHari<=0) <span class="badge badge-danger">Waktunya!</span>
                            @else <span class="badge badge-{{ $badgeHari }}">{{ $sisaHari }} hr</span>
                            @endif
                        </td>
                        <td class="d-none d-lg-table-cell text-muted" style="font-size:.8rem;">{{ $item->umur_saat_ini }} bln</td>
                        <td>
                            <span class="badge" style="font-size:.7rem;padding:3px 8px;border-radius:50px;background:{{ match($item->status){
                                'persiapan'=>'#607d8b','tanam'=>'#1565c0','tumbuh'=>'#2e7d32',
                                'siap_panen'=>'#e65100','panen'=>'#00695c','tunda'=>'#f57f17','gagal'=>'#c62828',default=>'#607d8b'
                            } }};color:#fff;">{{ $item->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('tanaman.show', $item) }}" class="btn btn-xs btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-5">Belum ada data penanaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tanaman->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
        <small class="text-muted">{{ $tanaman->firstItem() }}-{{ $tanaman->lastItem() }} dari {{ $tanaman->total() }}</small>
        {{ $tanaman->links() }}
    </div>
    @endif
</div>

{{-- Mobile pagination --}}
<div class="d-md-none mt-3">
    {{ $tanaman->links() }}
</div>

@endsection
