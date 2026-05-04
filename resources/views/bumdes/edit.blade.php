@extends('layouts.app')

@section('title', 'Edit BUMDes')
@section('page-title', 'Edit Data BUMDes')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('bumdes.index') }}">BUMDes</a></li>
    <li class="breadcrumb-item"><a href="{{ route('bumdes.show', $bumdes) }}">Detail</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form action="{{ route('bumdes.update', $bumdes) }}" method="POST">
@csrf
@method('PUT')
<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title">Data BUMDes</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Nama BUMDes</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $bumdes->nama) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Nomor SK</label>
                <input type="text" name="nomor_sk" class="form-control" value="{{ old('nomor_sk', $bumdes->nomor_sk) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="font-weight-bold">Tanggal SK</label>
                <input type="date" name="tanggal_sk" class="form-control" value="{{ old('tanggal_sk', optional($bumdes->tanggal_sk)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Direktur</label>
                <input type="text" name="direktur" class="form-control" value="{{ old('direktur', $bumdes->direktur) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Telepon</label>
                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $bumdes->telepon) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label class="font-weight-bold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $bumdes->email) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Rekening Bank</label>
                <input type="text" name="rekening_bank" class="form-control" value="{{ old('rekening_bank', $bumdes->rekening_bank) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-bold">Nama Bank</label>
                <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank', $bumdes->nama_bank) }}">
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header card-header-porang">
        <h3 class="card-title">Alamat BUMDes</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label class="font-weight-bold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $bumdes->alamat) }}</textarea>
        </div>
        <x-wilayah prefix="" :data="$bumdes" />
        <div class="form-check mt-3">
            <input type="hidden" name="aktif" value="0">
            <input type="checkbox" name="aktif" class="form-check-input" id="aktif" value="1" {{ old('aktif', $bumdes->aktif) ? 'checked' : '' }}>
            <label class="form-check-label" for="aktif">BUMDes aktif</label>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-success mr-2"><i class="fas fa-save mr-1"></i>Simpan</button>
<a href="{{ route('bumdes.show', $bumdes) }}" class="btn btn-secondary">Batal</a>
</form>
@endsection

@push('scripts')
@include('components.wilayah-script')
@endpush
