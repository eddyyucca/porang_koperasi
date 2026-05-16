@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')
@section('breadcrumb')
    <li class="breadcrumb-item active">Manajemen User</li>
@endsection

@push('styles')
<style>
    .badge-role { padding: 3px 10px; border-radius: 50px; font-size: .7rem; font-weight: 700; letter-spacing: .04em; }
    .role-superadmin { background: linear-gradient(135deg,#6f42c1,#9c27b0); color:#fff; }
    .role-admin      { background: linear-gradient(135deg,#1565c0,#1976d2); color:#fff; }
    .role-operator   { background: linear-gradient(135deg,#00838f,#00acc1); color:#fff; }
    .role-admin_desa { background: linear-gradient(135deg,#2e7d32,#43a047); color:#fff; }
    .role-petani     { background: linear-gradient(135deg,#e65100,#fb8c00); color:#fff; }
    .role-bumdes     { background: linear-gradient(135deg,#880e4f,#c2185b); color:#fff; }
</style>
@endpush

@section('content')

<div class="card">
    <div class="card-header card-header-porang d-flex align-items-center gap-2">
        <h3 class="card-title mb-0"><i class="fas fa-users-cog me-2"></i> Daftar User</h3>
        <a href="{{ route('users.create') }}" class="btn btn-light btn-sm ml-auto">
            <i class="fas fa-plus me-1"></i> Tambah User
        </a>
    </div>

    {{-- Filter --}}
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama / email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="role" class="form-control form-control-sm">
                    <option value="">Semua Role</option>
                    <option value="superadmin" @selected(request('role')=='superadmin')>Super Admin</option>
                    <option value="admin"       @selected(request('role')=='admin')>Admin</option>
                    <option value="operator"    @selected(request('role')=='operator')>Operator</option>
                    <option value="admin_desa"  @selected(request('role')=='admin_desa')>Admin Desa</option>
                    <option value="petani"      @selected(request('role')=='petani')>Petani</option>
                    <option value="bumdes"      @selected(request('role')=='bumdes')>BUMDes</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                @if(request()->hasAny(['search','role']))
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="40">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Wilayah / Link</th>
                        <th width="80">Status</th>
                        <th width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>
                        <td>
                            <div class="font-weight-bold" style="font-size:.9rem;">{{ $user->name }}</div>
                            @if($user->id === auth()->id())
                                <span class="badge badge-info" style="font-size:.65rem;">Anda</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge-role role-{{ $user->role }}">{{ $user->role_label }}</span>
                        </td>
                        <td class="small text-muted">
                            @if($user->isAdminDesa())
                                {{ $user->wilayah_desa_nama ?? $user->wilayah_kecamatan_nama ?? $user->wilayah_kabupaten_nama ?? '-' }}
                            @elseif($user->isPetani() && $user->anggota)
                                <i class="fas fa-user-circle text-warning"></i> {{ $user->anggota->nama_lengkap }}
                            @elseif($user->isBumdesRole() && $user->bumdes)
                                <i class="fas fa-building text-info"></i> {{ $user->bumdes->nama }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($user->aktif)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-xs btn-primary mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus user \"{{ addslashes($user->name) }}\"?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-users fa-3x mb-3 d-block" style="opacity:.3;"></i>
                            Belum ada user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="card-footer">{{ $users->links() }}</div>
    @endif
</div>

@endsection
