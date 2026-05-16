@extends('layouts.app')

@section('title', 'Tambah Tanaman')
@section('page-title', 'Tambah Data Penanaman')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('tanaman.index') }}">Tanaman</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<form action="{{ route('tanaman.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header card-header-porang"><h3 class="card-title">Data Penanaman</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Petani / Anggota <small class="text-muted">(kosongkan untuk lahan BUMDes)</small></label>
                        <select name="anggota_id" id="anggota-select" class="form-control" data-select2>
                            <option value="">-- Lahan BUMDes / Desa --</option>
                            @foreach($anggota as $item)
                                <option value="{{ $item->id }}" {{ (string) old('anggota_id', request('anggota_id')) === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_lengkap }} ({{ $item->nomor_anggota }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Lahan</label>
                        <select name="lahan_id" id="lahan-select" class="form-control" data-select2 {{ (old('anggota_id', request('anggota_id')) || $lahan->count()) ? '' : 'disabled' }} required>
                            <option value="">-- Pilih Lahan --</option>
                            @foreach($lahan as $item)
                                <option value="{{ $item->id }}" {{ (string) old('lahan_id', request('lahan_id')) === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_lahan }} ({{ number_format($item->luas_lahan, 2, ',', '.') }} {{ $item->satuan_luas }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Sumber Bibit</label>
                        <select name="sumber_bibit" class="form-control">
                            @foreach(['katak/bulbil','umbi','biji','kultur jaringan'] as $sumber)
                                <option value="{{ $sumber }}" {{ old('sumber_bibit', 'katak/bulbil') === $sumber ? 'selected' : '' }}>{{ ucfirst($sumber) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Jumlah Bibit</label>
                        <input type="number" name="jumlah_bibit" class="form-control" value="{{ old('jumlah_bibit') }}" min="1" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Luas Tanam</label>
                        <input type="number" step="0.01" name="luas_tanam" class="form-control" value="{{ old('luas_tanam') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Jarak Tanam X (cm) <span class="text-danger">*</span></label>
                        <input type="number" name="jarak_tanam_x_cm" id="jarakX" class="form-control"
                            value="{{ old('jarak_tanam_x_cm', 100) }}" min="30" max="300" required>
                        <small class="text-muted">Jarak antar baris</small>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Jarak Tanam Y (cm) <span class="text-danger">*</span></label>
                        <input type="number" name="jarak_tanam_y_cm" id="jarakY" class="form-control"
                            value="{{ old('jarak_tanam_y_cm', 100) }}" min="30" max="300" required>
                        <small class="text-muted">Jarak dalam baris</small>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="alert alert-primary py-2 mb-0" id="estimasiBatangBox" style="display:none;">
                            <i class="fas fa-calculator me-1"></i>
                            Estimasi batang porang: <strong id="estimasiBatangVal">—</strong>
                            <small class="text-muted ml-2" id="estimasiBatangNote"></small>
                        </div>
                    </div>
                    <input type="hidden" name="jarak_tanam" id="jarakTanamStr" value="{{ old('jarak_tanam', '100x100 cm') }}">
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Status</label>
                        <select name="status" class="form-control">
                            @foreach(['persiapan','tanam','tumbuh','siap_panen','panen','tunda','gagal'] as $status)
                                <option value="{{ $status }}" {{ old('status', 'persiapan') === $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Tanggal Tanam</label>
                        <input type="date" id="tanggal_tanam" name="tanggal_tanam" class="form-control" value="{{ old('tanggal_tanam') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Estimasi Panen</label>
                        <input type="date" id="estimasi_panen" name="estimasi_panen" class="form-control" value="{{ old('estimasi_panen') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Pupuk Digunakan</label>
                        <input type="text" name="pupuk_digunakan" class="form-control" value="{{ old('pupuk_digunakan') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Pestisida Digunakan</label>
                        <input type="text" name="pestisida_digunakan" class="form-control" value="{{ old('pestisida_digunakan') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Kendala</label>
                        <textarea name="kendala" class="form-control" rows="3">{{ old('kendala') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Upload Foto</label>
                        <input type="file" name="foto" class="form-control-file" id="fotoTanaman" accept="image/*">
                        <div id="previewFotoTanaman" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-success text-white">
            <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-lightbulb mr-2"></i>Tips Tanam Porang</h3>
            </div>
            <div class="card-body">
                <p class="mb-2">Waktu tanam optimal: Oktober - November (awal musim hujan)</p>
                <p class="mb-2">Jarak tanam ideal: 100 x 100 cm, kedalaman 10-15 cm</p>
                <p class="mb-2">Umur panen perdana: 18-24 bulan</p>
                <p class="mb-2">Kebutuhan air: sedang, hindari genangan</p>
                <p class="mb-0">Sumber bibit terbaik: katak/bulbil</p>
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
<a href="{{ route('tanaman.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
<script>
const anggotaApiBaseLahan = @json(url('/api/anggota'));
let lahanData = @json($lahan->values());

$('#anggota-select').on('change', function() {
    const anggotaId = this.value;
    const $lahan = $('#lahan-select');

    if (!anggotaId) {
        // Possibly BUMDes — if lahan was pre-loaded keep it, else disable
        if (lahanData.length === 0) {
            $lahan.html('<option value="">-- Pilih Lahan --</option>').prop('disabled', true).trigger('change.select2');
        }
        return;
    }

    $lahan.prop('disabled', true).html('<option value="">Memuat data lahan...</option>').trigger('change.select2');

    $.get(anggotaApiBaseLahan + '/' + anggotaId + '/lahan', function(data) {
        lahanData = data;
        let options = '<option value="">-- Pilih Lahan --</option>';
        data.forEach(function(item) {
            options += `<option value="${item.id}" data-luas="${item.luas_lahan}" data-satuan="${item.satuan_luas}">
                ${item.nama_lahan} (${Number(item.luas_lahan).toLocaleString('id-ID')} ${item.satuan_luas})
            </option>`;
        });
        $lahan.html(options).prop('disabled', false).trigger('change.select2');
    });
});

$('#lahan-select').on('change', hitungBatang);

$('#jarakX, #jarakY').on('input', function() {
    const x = $('#jarakX').val(), y = $('#jarakY').val();
    $('#jarakTanamStr').val(`${x}x${y} cm`);
    hitungBatang();
});

function hitungBatang() {
    const lahanId = $('#lahan-select').val();
    const x = parseFloat($('#jarakX').val()) || 100;
    const y = parseFloat($('#jarakY').val()) || 100;
    const lahan = lahanData.find(l => l.id == lahanId);

    if (!lahan) { $('#estimasiBatangBox').hide(); return; }

    let luasM2 = parseFloat(lahan.luas_lahan) || 0;
    if (lahan.satuan_luas === 'ha')  luasM2 *= 10000;
    if (lahan.satuan_luas === 'are') luasM2 *= 100;

    const jarak = (x / 100) * (y / 100);
    const batang = Math.floor(luasM2 / jarak);

    $('#estimasiBatangVal').text(batang.toLocaleString('id-ID') + ' batang');
    $('#estimasiBatangNote').text(`(${luasM2.toLocaleString('id-ID')} m² ÷ ${x}×${y} cm)`);
    $('#estimasiBatangBox').show();
}

$('#tanggal_tanam').on('change', function() {
    if (this.value) {
        const d = new Date(this.value);
        d.setMonth(d.getMonth() + 20);
        $('#estimasi_panen').val(d.toISOString().split('T')[0]);
    }
});

document.getElementById('fotoTanaman').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        document.getElementById('previewFotoTanaman').innerHTML =
            `<img src="${ev.target.result}" class="img-fluid rounded border" style="max-height:120px;">`;
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
