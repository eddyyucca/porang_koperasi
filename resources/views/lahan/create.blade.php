@extends('layouts.app')

@section('title', 'Tambah Lahan')
@section('page-title', 'Tambah Data Lahan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('lahan.index') }}">Lahan</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<form action="{{ route('lahan.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title">Informasi Lahan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Pemilik Type Toggle --}}
            <div class="col-12 mb-3">
                <label class="font-weight-bold d-block">Jenis Pemilik Lahan</label>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-primary {{ $defaultType === 'petani' ? 'active' : '' }}" id="btn-petani">
                        <input type="radio" name="pemilik_type" value="petani" {{ $defaultType === 'petani' ? 'checked' : '' }}>
                        <i class="fas fa-user-alt mr-1"></i> Petani / Anggota
                    </label>
                    <label class="btn btn-outline-success {{ $defaultType === 'bumdes' ? 'active' : '' }}" id="btn-bumdes">
                        <input type="radio" name="pemilik_type" value="bumdes" {{ $defaultType === 'bumdes' ? 'checked' : '' }}>
                        <i class="fas fa-landmark mr-1"></i> Lahan Desa (BUMDes)
                    </label>
                </div>
            </div>

            {{-- Petani panel --}}
            <div class="col-md-6 mb-3" id="panel-petani" style="{{ $defaultType === 'bumdes' ? 'display:none' : '' }}">
                <label class="font-weight-bold">Petani / Anggota</label>
                <select name="anggota_id" class="form-control" data-select2>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggota as $item)
                        <option value="{{ $item->id }}" {{ (string) old('anggota_id', optional($selectedAnggota)->id) === (string) $item->id ? 'selected' : '' }}>
                            {{ $item->nama_lengkap }} ({{ $item->nomor_anggota }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BUMDes panel --}}
            <div class="col-md-6 mb-3" id="panel-bumdes" style="{{ $defaultType === 'petani' ? 'display:none' : '' }}">
                <label class="font-weight-bold">BUMDes</label>
                <select name="bumdes_id" class="form-control" data-select2>
                    <option value="">-- Pilih BUMDes --</option>
                    @foreach($bumdes as $item)
                        <option value="{{ $item->id }}" {{ (string) old('bumdes_id', optional($selectedBumdes)->id) === (string) $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Nama Lahan</label>
                <input type="text" name="nama_lahan" class="form-control" value="{{ old('nama_lahan') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Luas Lahan</label>
                <input type="number" step="0.01" name="luas_lahan" class="form-control" value="{{ old('luas_lahan') }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Satuan Luas</label>
                <select name="satuan_luas" class="form-control">
                    @foreach(['m2','ha','are'] as $satuan)
                        <option value="{{ $satuan }}" {{ old('satuan_luas', 'm2') === $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Status Kepemilikan</label>
                <select name="status_kepemilikan" class="form-control">
                    @foreach(['milik sendiri','sewa','gadai','pinjam'] as $status)
                        <option value="{{ $status }}" {{ old('status_kepemilikan', 'milik sendiri') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Kondisi Tanah</label>
                <select name="kondisi_tanah" class="form-control">
                    @foreach(['subur','cukup subur','kurang subur'] as $kondisi)
                        <option value="{{ $kondisi }}" {{ old('kondisi_tanah', 'subur') === $kondisi ? 'selected' : '' }}>{{ ucfirst($kondisi) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title">Wilayah Lahan</h3>
    </div>
    <div class="card-body">
        <x-wilayah prefix="" :data="old()" />
        <div class="form-group mt-3">
            <label class="font-weight-bold">Alamat Lahan</label>
            <textarea name="alamat_lahan" class="form-control" rows="3">{{ old('alamat_lahan') }}</textarea>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title">Titik Koordinat (Opsional)</h3>
    </div>
    <div class="card-body">
        <div id="map-picker"></div>
        <div class="row mt-3">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-control" value="{{ old('latitude') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" value="{{ old('longitude') }}">
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-end">
                <button type="button" id="resetKoordinat" class="btn btn-secondary"><i class="fas fa-undo mr-1"></i>Reset Koordinat</button>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title">Dokumen & Catatan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Jenis Dokumen</label>
                <input type="text" name="jenis_dokumen" class="form-control" value="{{ old('jenis_dokumen') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Nomor Dokumen</label>
                <input type="text" name="nomor_dokumen" class="form-control" value="{{ old('nomor_dokumen') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Dokumen File</label>
                <input type="file" name="dokumen_file" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">PDF/JPG/PNG maks 5MB</small>
            </div>
            <div class="col-12">
                <label class="font-weight-bold">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
<a href="{{ route('lahan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
@include('components.wilayah-script')
<script>
// Pemilik type toggle
$('input[name="pemilik_type"]').on('change', function () {
    const val = $(this).val();
    if (val === 'petani') {
        $('#panel-petani').show();
        $('#panel-bumdes').hide();
        $('select[name="bumdes_id"]').val('');
    } else {
        $('#panel-petani').hide();
        $('#panel-bumdes').show();
        $('select[name="anggota_id"]').val('');
    }
});

// Map picker
const mapPicker = L.map('map-picker').setView([-2.5, 118], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapPicker);
let pickerMarker = null;

function setCoordinate(lat, lng) {
    $('#latitude').val(Number(lat).toFixed(8));
    $('#longitude').val(Number(lng).toFixed(8));
    if (pickerMarker) mapPicker.removeLayer(pickerMarker);
    pickerMarker = L.marker([lat, lng], { draggable: true }).addTo(mapPicker);
    pickerMarker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        $('#latitude').val(pos.lat.toFixed(8));
        $('#longitude').val(pos.lng.toFixed(8));
    });
}

mapPicker.on('click', function(e) { setCoordinate(e.latlng.lat, e.latlng.lng); });

$('#resetKoordinat').on('click', function() {
    $('#latitude, #longitude').val('');
    if (pickerMarker) { mapPicker.removeLayer(pickerMarker); pickerMarker = null; }
    mapPicker.setView([-2.5, 118], 5);
});

$('#latitude, #longitude').on('change', function() {
    const lat = parseFloat($('#latitude').val());
    const lng = parseFloat($('#longitude').val());
    if (!isNaN(lat) && !isNaN(lng)) { setCoordinate(lat, lng); mapPicker.setView([lat, lng], 13); }
});

@if(old('latitude') && old('longitude'))
setCoordinate({{ old('latitude') }}, {{ old('longitude') }});
mapPicker.setView([{{ old('latitude') }}, {{ old('longitude') }}], 13);
@endif
</script>
@endpush
