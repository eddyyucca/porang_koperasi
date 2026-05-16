@extends('layouts.app')

@section('title', 'Edit Kelompok Tani')
@section('page-title', 'Edit Kelompok Tani')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('kelompok-tani.index') }}">Kelompok Tani</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form action="{{ route('kelompok-tani.update', $kelompokTani) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title"><i class="fas fa-people-group me-2"></i> Informasi Kelompok Tani</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Nama Kelompok Tani <span class="text-danger">*</span></label>
                <input type="text" name="nama_kelompok" class="form-control @error('nama_kelompok') is-invalid @enderror"
                    value="{{ old('nama_kelompok', $kelompokTani->nama_kelompok) }}" required>
                @error('nama_kelompok')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Nomor SK Pembentukan</label>
                <input type="text" name="nomor_sk" class="form-control @error('nomor_sk') is-invalid @enderror"
                    value="{{ old('nomor_sk', $kelompokTani->nomor_sk) }}">
                @error('nomor_sk')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Tahun Berdiri</label>
                <input type="number" name="tahun_berdiri" class="form-control @error('tahun_berdiri') is-invalid @enderror"
                    value="{{ old('tahun_berdiri', $kelompokTani->tahun_berdiri) }}" min="1900" max="{{ date('Y') }}">
                @error('tahun_berdiri')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Komoditas Utama</label>
                <input type="text" name="komoditas_utama" class="form-control @error('komoditas_utama') is-invalid @enderror"
                    value="{{ old('komoditas_utama', $kelompokTani->komoditas_utama) }}">
                @error('komoditas_utama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Jumlah Anggota</label>
                <input type="number" name="jumlah_anggota" class="form-control @error('jumlah_anggota') is-invalid @enderror"
                    value="{{ old('jumlah_anggota', $kelompokTani->jumlah_anggota) }}" min="0">
                @error('jumlah_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Total Lahan (m²)</label>
                <input type="number" name="luas_lahan_total" class="form-control @error('luas_lahan_total') is-invalid @enderror"
                    value="{{ old('luas_lahan_total', $kelompokTani->luas_lahan_total) }}" min="0" step="0.01">
                @error('luas_lahan_total')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">BUMDes</label>
                <select name="bumdes_id" class="form-control select2 @error('bumdes_id') is-invalid @enderror">
                    <option value="">-- Pilih BUMDes --</option>
                    @foreach($bumdes as $b)
                        <option value="{{ $b->id }}" {{ old('bumdes_id', $kelompokTani->bumdes_id) == $b->id ? 'selected':'' }}>
                            {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
                @error('bumdes_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Koperasi</label>
                <select name="koperasi_id" class="form-control select2 @error('koperasi_id') is-invalid @enderror">
                    <option value="">-- Pilih Koperasi --</option>
                    @foreach($koperasi as $k)
                        <option value="{{ $k->id }}" {{ old('koperasi_id', $kelompokTani->koperasi_id) == $k->id ? 'selected':'' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
                @error('koperasi_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Foto Kelompok</label>
                @if($kelompokTani->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$kelompokTani->foto) }}" class="img-thumbnail" style="max-height:100px;">
                    </div>
                @endif
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="pending" {{ old('status', $kelompokTani->status) === 'pending' ? 'selected':'' }}>Pending</option>
                    <option value="aktif"   {{ old('status', $kelompokTani->status) === 'aktif'   ? 'selected':'' }}>Aktif</option>
                    <option value="ditolak" {{ old('status', $kelompokTani->status) === 'ditolak' ? 'selected':'' }}>Ditolak</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12 mb-3">
                <label class="font-weight-bold">Catatan Admin</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="2">{{ old('catatan', $kelompokTani->catatan) }}</textarea>
                @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title"><i class="fas fa-user-tie me-2"></i> Data Pengurus</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Nama Ketua <span class="text-danger">*</span></label>
                <input type="text" name="ketua_nama" class="form-control @error('ketua_nama') is-invalid @enderror"
                    value="{{ old('ketua_nama', $kelompokTani->ketua_nama) }}" required>
                @error('ketua_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">NIK Ketua</label>
                <input type="text" name="ketua_nik" class="form-control @error('ketua_nik') is-invalid @enderror"
                    value="{{ old('ketua_nik', $kelompokTani->ketua_nik) }}" maxlength="16">
                @error('ketua_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Telepon Ketua</label>
                <input type="text" name="ketua_telepon" class="form-control @error('ketua_telepon') is-invalid @enderror"
                    value="{{ old('ketua_telepon', $kelompokTani->ketua_telepon) }}">
                @error('ketua_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Sekretaris</label>
                <input type="text" name="sekretaris" class="form-control @error('sekretaris') is-invalid @enderror"
                    value="{{ old('sekretaris', $kelompokTani->sekretaris) }}">
                @error('sekretaris')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Bendahara</label>
                <input type="text" name="bendahara" class="form-control @error('bendahara') is-invalid @enderror"
                    value="{{ old('bendahara', $kelompokTani->bendahara) }}">
                @error('bendahara')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title"><i class="fas fa-map-marker-alt me-2"></i> Lokasi Kelompok Tani</h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="font-weight-bold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $kelompokTani->alamat) }}</textarea>
        </div>
        <x-wilayah prefix="" :data="$kelompokTani" />
    </div>
</div>

<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i> Perbarui</button>
<a href="{{ route('kelompok-tani.show', $kelompokTani) }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
@include('components.wilayah-script')
<script>
    $(document).ready(function() { $('.select2').select2({ theme: 'bootstrap4' }); });
</script>
@endpush
