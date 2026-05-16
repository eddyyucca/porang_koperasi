@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen User</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-porang">
        <h3 class="card-title mb-0"><i class="fas fa-user-plus me-2"></i> Form User Baru</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST" id="userForm">
        @csrf
        @include('users._form', ['user' => null])
        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('users._form_scripts')
@endpush
