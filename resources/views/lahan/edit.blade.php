@extends('layouts.app')

@section('title', 'Edit Lahan')
@section('page-title', 'Edit Data Lahan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('lahan.index') }}">Lahan</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lahan.show', $lahan) }}">Detail</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form action="{{ route('lahan.update', $lahan) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="card mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title">Informasi Lahan</h3></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Petani / Anggota</label>
                <select name="anggota_id" class="form-control" data-select2 required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggota as $item)
                        <option value="{{ $item->id }}" {{ (string) old('anggota_id', $lahan->anggota_id) === (string) $item->id ? 'selected' : '' }}>
                            {{ $item->nama_lengkap }} ({{ $item->nomor_anggota }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Nama Lahan</label>
                <input type="text" name="nama_lahan" class="form-control" value="{{ old('nama_lahan', $lahan->nama_lahan) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Luas Lahan</label>
                <input type="number" step="0.01" name="luas_lahan" class="form-control" value="{{ old('luas_lahan', $lahan->luas_lahan) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Satuan Luas</label>
                <select name="satuan_luas" class="form-control">
                    @foreach(['m2','ha','are'] as $satuan)
                        <option value="{{ $satuan }}" {{ old('satuan_luas', $lahan->satuan_luas) === $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Status Kepemilikan</label>
                <select name="status_kepemilikan" class="form-control">
                    @foreach(['milik sendiri','sewa','gadai','pinjam'] as $status)
                        <option value="{{ $status }}" {{ old('status_kepemilikan', $lahan->status_kepemilikan) === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Kondisi Tanah</label>
                <select name="kondisi_tanah" class="form-control">
                    @foreach(['subur','cukup subur','kurang subur'] as $kondisi)
                        <option value="{{ $kondisi }}" {{ old('kondisi_tanah', $lahan->kondisi_tanah) === $kondisi ? 'selected' : '' }}>{{ ucfirst($kondisi) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title">Wilayah Lahan</h3></div>
    <div class="card-body">
        <x-wilayah prefix="" :data="$lahan" />
        <div class="form-group mt-3">
            <label class="font-weight-bold">Alamat Lahan</label>
            <textarea name="alamat_lahan" class="form-control" rows="3">{{ old('alamat_lahan', $lahan->alamat_lahan) }}</textarea>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title">Titik Koordinat (Opsional)</h3></div>
    <div class="card-body">
        <div id="map-picker"></div>
        <div class="row mt-3">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-control" value="{{ old('latitude', $lahan->latitude) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" value="{{ old('longitude', $lahan->longitude) }}">
            </div>
            <div class="col-md-4 mb-3 d-flex align-items-end">
                <button type="button" id="resetKoordinat" class="btn btn-secondary"><i class="fas fa-undo mr-1"></i>Reset Koordinat</button>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title">Dokumen & Catatan</h3></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Jenis Dokumen</label>
                <input type="text" name="jenis_dokumen" class="form-control" value="{{ old('jenis_dokumen', $lahan->jenis_dokumen) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Nomor Dokumen</label>
                <input type="text" name="nomor_dokumen" class="form-control" value="{{ old('nomor_dokumen', $lahan->nomor_dokumen) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Dokumen File</label>
                <input type="file" name="dokumen_file" class="form-control-file" accept=".pdf,.jpg,.jpeg,.png">
                @if($lahan->dokumen_file)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $lahan->dokumen_file) }}" target="_blank">Lihat dokumen saat ini</a>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <label class="font-weight-bold">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $lahan->catatan) }}</textarea>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
<a href="{{ route('lahan.show', $lahan) }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
@include('components.wilayah-script')
<script>
const mapPicker = L.map('map-picker').setView([-2.5, 118], 5);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapPicker);

let pickerMarker = null;

function setCoordinate(lat, lng) {
    $('#latitude').val(Number(lat).toFixed(8));
    $('#longitude').val(Number(lng).toFixed(8));

    if (pickerMarker) {
        mapPicker.removeLayer(pickerMarker);
    }

    pickerMarker = L.marker([lat, lng], { draggable: true }).addTo(mapPicker);
    pickerMarker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        $('#latitude').val(pos.lat.toFixed(8));
        $('#longitude').val(pos.lng.toFixed(8));
    });
}

mapPicker.on('click', function(e) {
    setCoordinate(e.latlng.lat, e.latlng.lng);
});

$('#resetKoordinat').on('click', function() {
    $('#latitude, #longitude').val('');
    if (pickerMarker) {
        mapPicker.removeLayer(pickerMarker);
        pickerMarker = null;
    }
    mapPicker.setView([-2.5, 118], 5);
});

$('#latitude, #longitude').on('change', function() {
    const lat = parseFloat($('#latitude').val());
    const lng = parseFloat($('#longitude').val());
    if (!isNaN(lat) && !isNaN(lng)) {
        setCoordinate(lat, lng);
        mapPicker.setView([lat, lng], 13);
    }
});

@if(old('latitude', $lahan->latitude) && old('longitude', $lahan->longitude))
setCoordinate({{ old('latitude', $lahan->latitude) }}, {{ old('longitude', $lahan->longitude) }});
mapPicker.setView([{{ old('latitude', $lahan->latitude) }}, {{ old('longitude', $lahan->longitude) }}], 13);
@endif
</script>
@endpush
