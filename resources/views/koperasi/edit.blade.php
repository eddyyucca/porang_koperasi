@extends('layouts.app')

@section('title', 'Edit Koperasi')
@section('page-title', 'Edit Profil Koperasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('koperasi.index') }}">Koperasi</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form action="{{ route('koperasi.update') }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title">Profil Koperasi</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Logo</label>
                <input type="file" name="logo" class="form-control-file" id="logoInput" accept="image/*">
                @if($koperasi->logo)
                    <div class="mt-2"><img src="{{ asset('storage/' . $koperasi->logo) }}" alt="Logo" class="img-fluid rounded border" style="max-height:120px;"></div>
                @endif
                <div id="logoPreview" class="mt-2"></div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="font-weight-bold">Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $koperasi->nama) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Nomor Badan Hukum</label>
                        <input type="text" name="nomor_badan_hukum" class="form-control" value="{{ old('nomor_badan_hukum', $koperasi->nomor_badan_hukum) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Tanggal Berdiri</label>
                        <input type="date" name="tanggal_berdiri" class="form-control" value="{{ old('tanggal_berdiri', optional($koperasi->tanggal_berdiri)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Ketua</label>
                        <input type="text" name="ketua" class="form-control" value="{{ old('ketua', $koperasi->ketua) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Sekretaris</label>
                        <input type="text" name="sekretaris" class="form-control" value="{{ old('sekretaris', $koperasi->sekretaris) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Bendahara</label>
                        <input type="text" name="bendahara" class="form-control" value="{{ old('bendahara', $koperasi->bendahara) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $koperasi->telepon) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $koperasi->email) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $koperasi->kode_pos) }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="font-weight-bold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $koperasi->alamat) }}</textarea>
        </div>
        <x-wilayah prefix="" :data="$koperasi" />
        <div class="row mt-3">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Visi</label>
                <textarea name="visi" class="form-control" rows="4">{{ old('visi', $koperasi->visi) }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Misi</label>
                <textarea name="misi" class="form-control" rows="4">{{ old('misi', $koperasi->misi) }}</textarea>
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
<a href="{{ route('koperasi.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
@include('components.wilayah-script')
<script>
document.getElementById('logoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) {
        return;
    }

    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('logoPreview').innerHTML =
            '<img src="' + ev.target.result + '" class="img-fluid rounded border" style="max-height:120px;">';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
