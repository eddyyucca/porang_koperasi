@php $isEdit = isset($user) && $user !== null; @endphp

<div class="row">
    {{-- Nama --}}
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $isEdit ? $user->name : '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Email --}}
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $isEdit ? $user->email : '') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Password --}}
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">
            Password {{ $isEdit ? '<span class="text-muted font-weight-normal">(kosongkan jika tidak diubah)</span>' : '<span class="text-danger">*</span>' }}
        </label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            {{ $isEdit ? '' : 'required' }} placeholder="{{ $isEdit ? 'Biarkan kosong' : 'Min. 8 karakter' }}">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Konfirmasi Password {{ !$isEdit ? '<span class="text-danger">*</span>' : '' }}</label>
        <input type="password" name="password_confirmation" class="form-control"
            {{ $isEdit ? '' : 'required' }} placeholder="{{ $isEdit ? 'Biarkan kosong' : 'Ulangi password' }}">
    </div>

    {{-- Role --}}
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Role <span class="text-danger">*</span></label>
        <select name="role" id="roleSelect" class="form-control @error('role') is-invalid @enderror" required>
            <option value="">-- Pilih Role --</option>
            <option value="superadmin" @selected(old('role', $isEdit ? $user->role : '') === 'superadmin')>Super Admin</option>
            <option value="admin"      @selected(old('role', $isEdit ? $user->role : '') === 'admin')>Admin</option>
            <option value="operator"   @selected(old('role', $isEdit ? $user->role : '') === 'operator')>Operator</option>
            <option value="admin_desa" @selected(old('role', $isEdit ? $user->role : '') === 'admin_desa')>Admin Desa</option>
            <option value="petani"     @selected(old('role', $isEdit ? $user->role : '') === 'petani')>Petani</option>
            <option value="bumdes"     @selected(old('role', $isEdit ? $user->role : '') === 'bumdes')>BUMDes</option>
        </select>
        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <small class="text-muted" id="roleDesc"></small>
    </div>

    {{-- Status --}}
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Status</label>
        <div class="mt-2">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="aktifSwitch" name="aktif" value="1"
                    {{ old('aktif', $isEdit ? ($user->aktif ? '1' : '') : '1') ? 'checked' : '' }}>
                <label class="custom-control-label" for="aktifSwitch">Aktif</label>
            </div>
        </div>
    </div>
</div>

{{-- Admin Desa — Wilayah Panel --}}
<div id="panelWilayah" style="display:none;">
    <hr>
    <h6 class="font-weight-bold text-success mb-3"><i class="fas fa-map-marker-alt me-1"></i> Wilayah Admin Desa</h6>
    <p class="text-muted small">Admin desa hanya dapat melihat data dari wilayah yang ditentukan di bawah.</p>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Kabupaten / Kota</label>
            <select id="kabupatenSelect" class="form-control select2" name="wilayah_kabupaten_id">
                <option value="">-- Pilih Kabupaten --</option>
                @if($isEdit && $user->wilayah_kabupaten_id)
                    <option value="{{ $user->wilayah_kabupaten_id }}" selected>{{ $user->wilayah_kabupaten_nama }}</option>
                @endif
            </select>
            <input type="hidden" name="wilayah_kabupaten_nama" id="kabupatenNama"
                value="{{ old('wilayah_kabupaten_nama', $isEdit ? $user->wilayah_kabupaten_nama : '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Kecamatan</label>
            <select id="kecamatanSelect" class="form-control select2" name="wilayah_kecamatan_id">
                <option value="">-- Pilih Kecamatan --</option>
                @if($isEdit && $user->wilayah_kecamatan_id)
                    <option value="{{ $user->wilayah_kecamatan_id }}" selected>{{ $user->wilayah_kecamatan_nama }}</option>
                @endif
            </select>
            <input type="hidden" name="wilayah_kecamatan_nama" id="kecamatanNama"
                value="{{ old('wilayah_kecamatan_nama', $isEdit ? $user->wilayah_kecamatan_nama : '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="font-weight-bold">Desa / Kelurahan <span class="text-muted font-weight-normal">(opsional)</span></label>
            <select id="desaSelect" class="form-control select2" name="wilayah_desa_id">
                <option value="">-- Pilih Desa --</option>
                @if($isEdit && $user->wilayah_desa_id)
                    <option value="{{ $user->wilayah_desa_id }}" selected>{{ $user->wilayah_desa_nama }}</option>
                @endif
            </select>
            <input type="hidden" name="wilayah_desa_nama" id="desaNama"
                value="{{ old('wilayah_desa_nama', $isEdit ? $user->wilayah_desa_nama : '') }}">
        </div>
    </div>
</div>

{{-- Petani — Link Anggota --}}
<div id="panelPetani" style="display:none;">
    <hr>
    <h6 class="font-weight-bold text-warning mb-3"><i class="fas fa-user-circle me-1"></i> Link Akun Petani</h6>
    <div class="col-md-6 mb-3 px-0">
        <label class="font-weight-bold">Anggota / Petani</label>
        <select name="anggota_id" id="anggotaSelect" class="form-control select2">
            <option value="">-- Pilih Anggota --</option>
            @foreach($anggotaList as $a)
                <option value="{{ $a->id }}"
                    @selected(old('anggota_id', $isEdit ? $user->anggota_id : '') == $a->id)>
                    {{ $a->nama_lengkap }} ({{ $a->nomor_anggota }})
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- BUMDes — Link BUMDes --}}
<div id="panelBumdes" style="display:none;">
    <hr>
    <h6 class="font-weight-bold text-info mb-3"><i class="fas fa-building me-1"></i> Link Akun BUMDes</h6>
    <div class="col-md-6 mb-3 px-0">
        <label class="font-weight-bold">BUMDes</label>
        <select name="bumdes_id" id="bumdesSelect" class="form-control select2">
            <option value="">-- Pilih BUMDes --</option>
            @foreach($bumdesList as $b)
                <option value="{{ $b->id }}"
                    @selected(old('bumdes_id', $isEdit ? $user->bumdes_id : '') == $b->id)>
                    {{ $b->nama }}
                </option>
            @endforeach
        </select>
    </div>
</div>

{{-- Role descriptions --}}
<div class="alert alert-info small mt-2" id="roleInfo" style="display:none;"></div>
