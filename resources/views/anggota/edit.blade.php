@extends('layouts.app')

@section('title', 'Edit Data Anggota')
@section('page-title', 'Edit Data Anggota')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('anggota.index') }}">Data Petani</a></li>
    <li class="breadcrumb-item"><a href="{{ route('anggota.show', $anggota) }}">Detail</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form action="{{ route('anggota.update', $anggota) }}" method="POST" enctype="multipart/form-data" id="formAnggota">
@csrf
@method('PUT')

<div class="card shadow-sm mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title"><i class="fas fa-id-card mr-2"></i>Jenis Keanggotaan</h3></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="font-weight-bold">Jenis Anggota <span class="text-danger">*</span></label>
                <div>
                    <div class="icheck-success d-inline mr-4">
                        <input type="radio" name="jenis_anggota" id="jenis_personal" value="personal"
                            {{ old('jenis_anggota', $anggota->jenis_anggota) === 'personal' ? 'checked' : '' }}>
                        <label for="jenis_personal"><i class="fas fa-user"></i> Personal</label>
                    </div>
                    <div class="icheck-info d-inline">
                        <input type="radio" name="jenis_anggota" id="jenis_bumdes" value="bumdes"
                            {{ old('jenis_anggota', $anggota->jenis_anggota) === 'bumdes' ? 'checked' : '' }}>
                        <label for="jenis_bumdes"><i class="fas fa-landmark"></i> BUMDes</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="field-bumdes" style="{{ old('jenis_anggota', $anggota->jenis_anggota) === 'bumdes' ? '' : 'display:none' }}">
                <label class="font-weight-bold">Pilih BUMDes <span class="text-danger">*</span></label>
                <select name="bumdes_id" class="form-control" data-select2>
                    <option value="">-- Pilih BUMDes --</option>
                    @foreach($bumdes as $b)
                        <option value="{{ $b->id }}" {{ (string) old('bumdes_id', $anggota->bumdes_id) === (string) $b->id ? 'selected' : '' }}>
                            {{ $b->nama }} - {{ $b->desa_nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="font-weight-bold">Tanggal Daftar <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_daftar" class="form-control" value="{{ old('tanggal_daftar', optional($anggota->tanggal_daftar)->format('Y-m-d')) }}" required>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title"><i class="fas fa-id-card mr-2"></i>Data KTP</h3></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">NIK (16 digit) <span class="text-danger">*</span></label>
                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                    value="{{ old('nik', $anggota->nik) }}" maxlength="16" pattern="\d{16}" required>
                @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-5 mb-3">
                <label class="font-weight-bold">Nama Lengkap (sesuai KTP) <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                    value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}" required>
                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="L" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $anggota->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($anggota->tanggal_lahir)->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Golongan Darah</label>
                <select name="golongan_darah" class="form-control">
                    @foreach(['-','A','B','AB','O'] as $gol)
                        <option value="{{ $gol }}" {{ old('golongan_darah', $anggota->golongan_darah) === $gol ? 'selected' : '' }}>{{ $gol }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Agama</label>
                <select name="agama" class="form-control">
                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                        <option value="{{ $ag }}" {{ old('agama', $anggota->agama) === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Status Perkawinan</label>
                <select name="status_perkawinan" class="form-control">
                    @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sp)
                        <option value="{{ $sp }}" {{ old('status_perkawinan', $anggota->status_perkawinan) === $sp ? 'selected' : '' }}>{{ $sp }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Pendidikan Terakhir</label>
                <select name="pendidikan" class="form-control">
                    <option value="">-- Pilih --</option>
                    @foreach(['Tidak Sekolah','SD','SMP','SMA/SMK','D3','S1','S2','S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan', $anggota->pendidikan) === $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Pekerjaan (KTP)</label>
                <input type="text" name="pekerjaan_ktp" class="form-control"
                    value="{{ old('pekerjaan_ktp', $anggota->pekerjaan_ktp) }}">
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title"><i class="fas fa-map-marker-alt mr-2"></i>Alamat KTP</h3></div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="font-weight-bold">Alamat Jalan <span class="text-danger">*</span></label>
                <textarea name="alamat_ktp" class="form-control" rows="2" required>{{ old('alamat_ktp', $anggota->alamat_ktp) }}</textarea>
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold">RT</label>
                <input type="text" name="rt_ktp" class="form-control" value="{{ old('rt_ktp', $anggota->rt_ktp) }}">
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold">RW</label>
                <input type="text" name="rw_ktp" class="form-control" value="{{ old('rw_ktp', $anggota->rw_ktp) }}">
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold">Kode Pos</label>
                <input type="text" name="kode_pos_ktp" class="form-control" value="{{ old('kode_pos_ktp', $anggota->kode_pos_ktp) }}" maxlength="5">
            </div>
        </div>
        <x-wilayah prefix="ktp" :data="$anggota" />
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-header card-header-porang"><h3 class="card-title"><i class="fas fa-phone mr-2"></i>Kontak, Rekening & Foto</h3></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">No. Telepon / HP</label>
                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $anggota->telepon) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $anggota->email) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Status Keanggotaan</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ old('status', $anggota->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="aktif" {{ old('status', $anggota->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status', $anggota->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">No. Rekening Bank</label>
                <input type="text" name="no_rekening" class="form-control" value="{{ old('no_rekening', $anggota->no_rekening) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Nama Bank</label>
                <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', $anggota->nama_bank) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Koperasi</label>
                <select name="koperasi_id" class="form-control" data-select2>
                    <option value="">-- Pilih Koperasi --</option>
                    @foreach($koperasi as $k)
                        <option value="{{ $k->id }}" {{ (string) old('koperasi_id', $anggota->koperasi_id) === (string) $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Foto KTP</label>
                <input type="file" name="foto_ktp" class="form-control-file" accept="image/*" id="inputFotoKtp">
                @if($anggota->foto_ktp)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $anggota->foto_ktp) }}" alt="Foto KTP" class="img-fluid rounded border" style="max-height:120px;">
                    </div>
                @endif
                <div id="previewKtp" class="mt-2"></div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Foto Diri</label>
                <input type="file" name="foto_diri" class="form-control-file" accept="image/*" id="inputFotoDiri">
                @if($anggota->foto_diri)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $anggota->foto_diri) }}" alt="Foto Diri" class="img-fluid rounded border" style="max-height:120px;">
                    </div>
                @endif
                <div id="previewDiri" class="mt-2"></div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap mb-4">
    <button type="submit" class="btn btn-success btn-lg mr-2 mb-2">
        <i class="fas fa-save mr-1"></i>Simpan Perubahan
    </button>
    <a href="{{ route('anggota.show', $anggota) }}" class="btn btn-secondary btn-lg mb-2">Batal</a>
</div>

</form>
@endsection

@push('scripts')
@include('components.wilayah-script')
<script>
function syncBumdesField() {
    const isBumdes = $('input[name=jenis_anggota]:checked').val() === 'bumdes';
    const bumdesSelect = $('select[name=bumdes_id]');
    $('#field-bumdes').toggle(isBumdes);
    bumdesSelect.prop('required', isBumdes);

    if (!isBumdes) {
        bumdesSelect.val('').trigger('change');
    }
}

$('input[name=jenis_anggota]').on('change', syncBumdesField);
syncBumdesField();

function previewImg(inputId, previewId) {
    const input = document.getElementById(inputId);
    if (!input) {
        return;
    }

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById(previewId).innerHTML =
                '<img src="' + ev.target.result + '" style="max-height:120px;border-radius:6px;border:1px solid #ddd;">';
        };
        reader.readAsDataURL(file);
    });
}

previewImg('inputFotoKtp', 'previewKtp');
previewImg('inputFotoDiri', 'previewDiri');
</script>
@endpush
