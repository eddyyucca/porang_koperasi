@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen User</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-porang">
        <h3 class="card-title mb-0"><i class="fas fa-user-edit me-2"></i> Edit: {{ $user->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user) }}" method="POST" id="userForm">
        @csrf @method('PUT')
        @include('users._form', ['user' => $user])
        <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Perbarui</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
        </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('users._form_scripts')
@endpush
