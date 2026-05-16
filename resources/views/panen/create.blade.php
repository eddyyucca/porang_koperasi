@extends('layouts.app')

@section('title', 'Tambah Panen')
@section('page-title', 'Catat Panen')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('panen.index') }}">Panen</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<form action="{{ route('panen.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Data Panen</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Petani / Anggota</label>
                        <select name="anggota_id" id="anggota-select" class="form-control" data-select2>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggota as $item)
                                <option value="{{ $item->id }}" {{ (string) old('anggota_id', request('anggota_id')) === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_lengkap }} ({{ $item->nomor_anggota }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Tanaman</label>
                        <select name="tanaman_id" id="tanaman-select" class="form-control" data-select2 {{ old('anggota_id', request('anggota_id')) ? '' : 'disabled' }} required>
                            <option value="">-- Pilih Tanaman --</option>
                            @foreach($tanaman as $item)
                                <option value="{{ $item->id }}" {{ (string) old('tanaman_id', request('tanaman_id')) === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->lahan->nama_lahan ?? '-' }} ({{ ucfirst($item->status) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Tanggal Panen</label>
                        <input type="date" name="tanggal_panen" class="form-control" value="{{ old('tanggal_panen', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Berat Panen (kg)</label>
                        <input type="number" step="0.1" id="berat_panen_kg" name="berat_panen_kg" class="form-control" value="{{ old('berat_panen_kg') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Harga per kg</label>
                        <input type="number" id="harga_per_kg" name="harga_per_kg" class="form-control" value="{{ old('harga_per_kg') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Total Nilai</label>
                        <input type="text" id="total_nilai" name="total_nilai" class="form-control" value="{{ old('total_nilai') }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <div>
                            <small class="text-muted d-block">Preview</small>
                            <strong id="preview_nilai">Rp 0</strong>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Pembeli</label>
                        <input type="text" name="pembeli" class="form-control" value="{{ old('pembeli') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Metode Jual</label>
                        <select name="metode_jual" class="form-control">
                            @foreach(['koperasi','pasar','tengkulak','ekspor','langsung'] as $metode)
                                <option value="{{ $metode }}" {{ old('metode_jual', 'koperasi') === $metode ? 'selected' : '' }}>{{ ucfirst($metode) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Status Jual</label>
                        <select name="status_jual" class="form-control">
                            @foreach(['belum terjual','sebagian','terjual'] as $status)
                                <option value="{{ $status }}" {{ old('status_jual', 'belum terjual') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Upload Foto</label>
                        <input type="file" name="foto" class="form-control-file" id="fotoPanen" accept="image/*">
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
                <p class="mb-2">Harga porang ditetapkan oleh admin dan berlaku seragam untuk semua hasil panen.</p>
                <p class="mb-0">Lihat harga terkini di menu <strong>Harga Porang</strong>.</p>
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
<a href="{{ route('panen.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
<script>
const anggotaApiBaseTanaman = @json(url('/api/anggota'));

$('#anggota-select').on('change', function() {
    const anggotaId = this.value;
    const $tanaman = $('#tanaman-select');
    $tanaman.prop('disabled', true).html('<option value="">Memuat data tanaman...</option>').trigger('change.select2');

    if (!anggotaId) {
        $tanaman.html('<option value="">-- Pilih Tanaman --</option>').prop('disabled', true).trigger('change.select2');
        return;
    }

    $.get(anggotaApiBaseTanaman + '/' + anggotaId + '/tanaman', function(data) {
        let options = '<option value="">-- Pilih Tanaman --</option>';
        data.forEach(function(item) {
            const lahan = item.lahan ? item.lahan.nama_lahan : '-';
            options += '<option value="' + item.id + '">' + lahan + ' (' + item.status + ')</option>';
        });
        $tanaman.html(options).prop('disabled', false).trigger('change.select2');
    });
});

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
