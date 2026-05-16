@extends('layouts.app')

@section('title', 'Edit Panen')
@section('page-title', 'Edit Data Panen')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('panen.index') }}">Panen</a></li>
    <li class="breadcrumb-item"><a href="{{ route('panen.show', $panen) }}">Detail</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form action="{{ route('panen.update', $panen) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Data Panen</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Petani / Anggota</label>
                        <select name="anggota_id" class="form-control" data-select2 disabled>
                            @foreach($anggota as $item)
                                <option value="{{ $item->id }}" {{ (string) $panen->anggota_id === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_lengkap }} ({{ $item->nomor_anggota }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Tanaman</label>
                        <select name="tanaman_id" class="form-control" data-select2 required>
                            <option value="">-- Pilih Tanaman --</option>
                            @foreach($tanaman as $item)
                                <option value="{{ $item->id }}" {{ (string) old('tanaman_id', $panen->tanaman_id) === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->lahan->nama_lahan ?? '-' }} ({{ ucfirst($item->status) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Tanggal Panen</label>
                        <input type="date" name="tanggal_panen" class="form-control" value="{{ old('tanggal_panen', optional($panen->tanggal_panen)->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Berat Panen (kg)</label>
                        <input type="number" step="0.1" id="berat_panen_kg" name="berat_panen_kg" class="form-control" value="{{ old('berat_panen_kg', $panen->berat_panen_kg) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Harga per kg</label>
                        <input type="number" id="harga_per_kg" name="harga_per_kg" class="form-control" value="{{ old('harga_per_kg', $panen->harga_per_kg) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Total Nilai</label>
                        <input type="text" id="total_nilai" name="total_nilai" class="form-control" value="{{ old('total_nilai', $panen->total_nilai) }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <div>
                            <small class="text-muted d-block">Preview</small>
                            <strong id="preview_nilai">Rp 0</strong>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Pembeli</label>
                        <input type="text" name="pembeli" class="form-control" value="{{ old('pembeli', $panen->pembeli) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Metode Jual</label>
                        <select name="metode_jual" class="form-control">
                            @foreach(['koperasi','pasar','tengkulak','ekspor','langsung'] as $metode)
                                <option value="{{ $metode }}" {{ old('metode_jual', $panen->metode_jual) === $metode ? 'selected' : '' }}>{{ ucfirst($metode) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Status Jual</label>
                        <select name="status_jual" class="form-control">
                            @foreach(['belum terjual','sebagian','terjual'] as $status)
                                <option value="{{ $status }}" {{ old('status_jual', $panen->status_jual) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $panen->catatan) }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Upload Foto</label>
                        <input type="file" name="foto" class="form-control-file" id="fotoPanen" accept="image/*">
                        @if($panen->foto)
                            <div class="mt-2"><img src="{{ asset('storage/' . $panen->foto) }}" alt="Foto Panen" class="img-fluid rounded border" style="max-height:120px;"></div>
                        @endif
                        <div id="previewFotoPanen" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-success text-white">
            <div class="card-header border-0"><h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Info</h3></div>
            <div class="card-body">
                <p class="mb-0">Harga porang ditetapkan oleh admin dan berlaku seragam untuk semua hasil panen.</p>
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
<a href="{{ route('panen.show', $panen) }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
<script>
function hitungNilai() {
    const berat = parseFloat($('#berat_panen_kg').val()) || 0;
    const harga = parseFloat($('#harga_per_kg').val()) || 0;
    const total = berat * harga;
    $('#total_nilai').val(total.toFixed(0));
    $('#preview_nilai').text('Rp ' + total.toLocaleString('id-ID'));
}

$('#berat_panen_kg, #harga_per_kg').on('input change', hitungNilai);
hitungNilai();

document.getElementById('fotoPanen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) {
        return;
    }
    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('previewFotoPanen').innerHTML =
            '<img src="' + ev.target.result + '" class="img-fluid rounded border" style="max-height:120px;">';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
