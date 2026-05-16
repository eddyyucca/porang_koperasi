<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota | Koperasi Barakat Pangan Banua</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --green-dark: #1a4d2e;
            --green:      #2d6a2d;
            --green-mid:  #3a7d44;
            --green-light:#5a9e5a;
            --green-pale: #d4edda;
            --yellow:     #f5c518;
            --yellow-dark:#e8a805;
            --yellow-pale:#fff8e1;
            --cream:      #faf7f2;
            --blue:       #1565c0;
            --blue-pale:  #e3f2fd;
            --orange:     #e65100;
            --orange-pale:#fff3e0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            color: #1a1a1a;
        }

        /* ── Header ─────────────────────────────── */
        .page-header {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 100%);
            padding: 28px 24px;
            text-align: center;
        }
        .header-logo {
            display: inline-flex; align-items: center; gap: 12px;
            margin-bottom: 10px; text-decoration: none;
        }
        .logo-icon {
            width: 46px; height: 46px;
            background: var(--yellow); border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: var(--green-dark);
            box-shadow: 0 4px 12px rgba(245,197,24,.4);
        }
        .logo-text strong { display: block; color: #fff; font-size: 1.1rem; font-weight: 700; line-height: 1.2; }
        .logo-text span   { color: var(--yellow); font-size: .72rem; font-weight: 500; letter-spacing: .06em; text-transform: uppercase; }
        .page-header h1   { color: #fff; font-size: 1.4rem; font-weight: 600; }
        .page-header p    { color: rgba(255,255,255,.75); font-size: .88rem; margin-top: 4px; }

        /* ── Container ───────────────────────────── */
        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 32px 16px 60px;
        }
        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            color: var(--green); font-size: .88rem; text-decoration: none; margin-bottom: 24px;
        }
        .back-link:hover { color: var(--green-dark); }

        /* ── Type Selector ───────────────────────── */
        .type-section { margin-bottom: 28px; }
        .type-section h3 {
            font-size: .9rem; font-weight: 700; color: #374151;
            text-transform: uppercase; letter-spacing: .06em; margin-bottom: 14px;
        }
        .type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }
        @media (max-width: 600px) { .type-grid { grid-template-columns: 1fr; } }

        .type-card {
            position: relative;
            border: 2.5px solid #e5e7eb;
            border-radius: 16px;
            padding: 22px 16px;
            text-align: center;
            cursor: pointer;
            background: #fff;
            transition: all .25s;
            user-select: none;
        }
        .type-card:hover { border-color: var(--green-light); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.07); }
        .type-card input[type=radio] { position: absolute; opacity: 0; width: 0; height: 0; }
        .type-card .type-icon {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px; font-size: 22px;
            transition: all .25s;
        }
        .type-card .type-name { font-weight: 700; font-size: .95rem; color: #111; margin-bottom: 4px; }
        .type-card .type-desc { font-size: .78rem; color: #6b7280; line-height: 1.4; }

        /* Mandiri */
        .type-card[data-type=mandiri] .type-icon { background: var(--green-pale); color: var(--green-dark); }
        .type-card[data-type=mandiri].selected { border-color: var(--green); background: #f0faf0; box-shadow: 0 0 0 4px rgba(45,106,45,.12); }
        .type-card[data-type=mandiri].selected .type-icon { background: var(--green); color: #fff; }

        /* Kelompok Tani */
        .type-card[data-type=kelompok_tani] .type-icon { background: var(--yellow-pale); color: var(--yellow-dark); }
        .type-card[data-type=kelompok_tani].selected { border-color: var(--yellow-dark); background: #fffdf0; box-shadow: 0 0 0 4px rgba(232,168,5,.14); }
        .type-card[data-type=kelompok_tani].selected .type-icon { background: var(--yellow); color: var(--green-dark); }

        /* BUMDes */
        .type-card[data-type=bumdes] .type-icon { background: var(--blue-pale); color: var(--blue); }
        .type-card[data-type=bumdes].selected { border-color: var(--blue); background: #f0f6ff; box-shadow: 0 0 0 4px rgba(21,101,192,.12); }
        .type-card[data-type=bumdes].selected .type-icon { background: var(--blue); color: #fff; }

        .type-check {
            position: absolute; top: 10px; right: 10px;
            width: 22px; height: 22px; border-radius: 50%;
            background: #e5e7eb; display: flex; align-items: center; justify-content: center;
            font-size: 11px; color: transparent; transition: all .25s;
        }
        .type-card.selected .type-check { background: var(--green); color: #fff; }
        .type-card[data-type=kelompok_tani].selected .type-check { background: var(--yellow-dark); }
        .type-card[data-type=bumdes].selected .type-check { background: var(--blue); }

        /* ── Context Panel ───────────────────────── */
        .context-panel {
            background: #fff;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: none;
            align-items: flex-start;
            gap: 12px;
            border-left: 4px solid var(--green);
        }
        .context-panel.show { display: flex; }
        .context-panel .ctx-icon { font-size: 1.2rem; margin-top: 1px; flex-shrink: 0; }
        .context-panel p { font-size: .84rem; color: #374151; line-height: 1.6; }
        .context-panel strong { display: block; font-size: .88rem; margin-bottom: 3px; }

        /* ── Card ────────────────────────────────── */
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card-head {
            background: var(--green);
            color: #fff;
            padding: 13px 20px;
            font-weight: 600;
            font-size: .92rem;
            display: flex; align-items: center; gap: 8px;
        }
        .card-body { padding: 20px; }

        /* ── Form ────────────────────────────────── */
        .row { display: flex; flex-wrap: wrap; margin: 0 -8px; }
        .col { padding: 0 8px; margin-bottom: 14px; flex: 1 1 100%; }
        .col-2 { flex: 1 1 calc(50% - 16px); min-width: 180px; }
        .col-3 { flex: 1 1 calc(33.33% - 16px); min-width: 160px; }
        @media (max-width: 600px) { .col-2, .col-3 { flex: 1 1 100%; } }

        label { display: block; font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
        label .req { color: #dc3545; }
        input, select, textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: .88rem;
            color: #111;
            background: #fafafa;
            transition: border-color .2s, background .2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--green-mid); background: #fff;
        }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { color: #dc3545; font-size: .78rem; margin-top: 4px; display: block; }

        /* Kelompok / BUMDes select box */
        .select-group { display: none; }
        .select-group.show { display: block; margin-bottom: 20px; }
        .select-box {
            background: var(--yellow-pale);
            border: 2px solid var(--yellow-dark);
            border-radius: 12px;
            padding: 16px;
        }
        .select-box.blue {
            background: var(--blue-pale);
            border-color: var(--blue);
        }
        .select-box label { font-size: .9rem; font-weight: 700; color: var(--green-dark); }
        .select-box.blue label { color: var(--blue); }
        .select-box select {
            background: #fff; border: 1.5px solid rgba(0,0,0,.15);
            margin-top: 6px;
        }
        .select-box .help-text {
            font-size: .78rem; color: #6b7280; margin-top: 6px;
        }
        .no-data-msg {
            background: #fef3cd;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: .82rem;
            color: #856404;
            margin-top: 8px;
        }

        /* Wilayah */
        .wilayah-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media (max-width: 600px) { .wilayah-grid { grid-template-columns: 1fr; } }

        /* Submit */
        .submit-wrap { margin-top: 8px; }
        .btn-submit {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
            color: #fff; border: none; border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem; font-weight: 700; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: all .3s;
            box-shadow: 0 6px 20px rgba(45,106,45,.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(45,106,45,.4); }

        .notice {
            background: var(--green-pale);
            border-left: 4px solid var(--green);
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            font-size: .84rem; color: var(--green-dark);
            margin-bottom: 24px;
        }
        .alert-error {
            background: #fee2e2;
            border-left: 4px solid #dc3545;
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            font-size: .84rem; color: #7f1d1d;
            margin-bottom: 20px;
        }

        /* Step indicator */
        .step-bar {
            display: flex; align-items: center; gap: 0;
            margin-bottom: 28px;
        }
        .step-item-bar { display: flex; align-items: center; flex: 1; }
        .step-dot {
            width: 32px; height: 32px; border-radius: 50%;
            background: #e5e7eb; color: #9ca3af;
            font-size: .8rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; transition: all .3s;
        }
        .step-dot.done { background: var(--green); color: #fff; }
        .step-label { font-size: .74rem; color: #9ca3af; margin-left: 8px; font-weight: 500; white-space: nowrap; }
        .step-dot.done + .step-label { color: var(--green-dark); font-weight: 600; }
        .step-line { flex: 1; height: 2px; background: #e5e7eb; margin: 0 8px; }
        .step-line.done { background: var(--green); }
    </style>
</head>
<body>

<div class="page-header">
    <a href="{{ route('home') }}" class="header-logo">
        <div class="logo-icon"><i class="fas fa-seedling"></i></div>
        <div class="logo-text">
            <strong>Koperasi Barakat Pangan Banua</strong>
            <span>Pendaftaran Anggota</span>
        </div>
    </a>
    <h1>Formulir Pendaftaran Anggota</h1>
    <p>Daftarkan diri Anda — gratis, cepat, tanpa biaya apapun</p>
</div>

<div class="container">
    <a href="{{ route('home') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>

    @if($errors->any())
    <div class="alert-error">
        <strong><i class="fas fa-exclamation-triangle"></i> Periksa kembali data Anda:</strong>
        <ul style="margin:6px 0 0 16px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="notice">
        <i class="fas fa-info-circle"></i>
        <strong>Tanpa upload foto</strong> — pendaftaran cukup mengisi data diri. Foto KTP dan dokumen lainnya dapat dilengkapi setelah verifikasi oleh admin.
    </div>

    <form action="{{ route('daftar.store') }}" method="POST" id="regForm">
    @csrf

    {{-- ── Pilih Jenis Pendaftaran ── --}}
    <div class="type-section">
        <h3><i class="fas fa-list-ul" style="color:var(--green);margin-right:6px;"></i> Pilih Jenis Keanggotaan</h3>
        <div class="type-grid">

            {{-- Tani Mandiri --}}
            <label class="type-card {{ old('jenis_anggota','mandiri') === 'mandiri' ? 'selected':'' }}" data-type="mandiri">
                <input type="radio" name="jenis_anggota" value="mandiri"
                    {{ old('jenis_anggota','mandiri') === 'mandiri' ? 'checked':'' }}>
                <div class="type-check"><i class="fas fa-check"></i></div>
                <div class="type-icon"><i class="fas fa-user"></i></div>
                <div class="type-name">Tani Mandiri</div>
                <div class="type-desc">Petani perorangan yang mendaftar secara individu</div>
            </label>

            {{-- Kelompok Tani --}}
            <label class="type-card {{ old('jenis_anggota') === 'kelompok_tani' ? 'selected':'' }}" data-type="kelompok_tani">
                <input type="radio" name="jenis_anggota" value="kelompok_tani"
                    {{ old('jenis_anggota') === 'kelompok_tani' ? 'checked':'' }}>
                <div class="type-check"><i class="fas fa-check"></i></div>
                <div class="type-icon"><i class="fas fa-people-group"></i></div>
                <div class="type-name">Kelompok Tani</div>
                <div class="type-desc">Anggota dari kelompok tani yang sudah terdaftar</div>
            </label>

            {{-- BUMDes --}}
            <label class="type-card {{ old('jenis_anggota') === 'bumdes' ? 'selected':'' }}" data-type="bumdes">
                <input type="radio" name="jenis_anggota" value="bumdes"
                    {{ old('jenis_anggota') === 'bumdes' ? 'checked':'' }}>
                <div class="type-check"><i class="fas fa-check"></i></div>
                <div class="type-icon"><i class="fas fa-landmark"></i></div>
                <div class="type-name">BUMDes</div>
                <div class="type-desc">Anggota melalui Badan Usaha Milik Desa</div>
            </label>

        </div>
    </div>

    {{-- ── Pilih Kelompok Tani ── --}}
    <div class="select-group {{ old('jenis_anggota') === 'kelompok_tani' ? 'show':'' }}" id="panelKelompok">
        <div class="select-box">
            <label><i class="fas fa-people-group" style="margin-right:6px;color:var(--yellow-dark);"></i> Pilih Kelompok Tani <span class="req">*</span></label>
            @if($kelompokTani->isNotEmpty())
                <select name="kelompok_tani_id" id="selKelompok"
                    class="{{ $errors->has('kelompok_tani_id') ? 'is-invalid':'' }}">
                    <option value="">-- Pilih kelompok tani Anda --</option>
                    @foreach($kelompokTani as $kt)
                        <option value="{{ $kt->id }}"
                            {{ old('kelompok_tani_id') == $kt->id ? 'selected':'' }}
                            data-lokasi="{{ implode(', ', array_filter([$kt->desa_nama, $kt->kecamatan_nama, $kt->kabupaten_nama])) }}"
                            data-ketua="{{ $kt->ketua_nama }}">
                            {{ $kt->nama_kelompok }}
                        </option>
                    @endforeach
                </select>
                @error('kelompok_tani_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                <div id="ktInfo" style="display:none;margin-top:10px;padding:10px 14px;background:#fff;border-radius:8px;font-size:.82rem;color:#374151;border:1px solid #e5e7eb;">
                    <i class="fas fa-map-marker-alt" style="color:var(--green);margin-right:6px;"></i>
                    <span id="ktLokasi"></span>
                    &nbsp;&bull;&nbsp;
                    <i class="fas fa-user-tie" style="color:var(--green);margin-right:4px;"></i>Ketua: <span id="ktKetua"></span>
                </div>
                <div class="help-text"><i class="fas fa-info-circle"></i> Jika kelompok tani Anda belum terdaftar, hubungi admin koperasi untuk mendaftarkannya terlebih dahulu.</div>
            @else
                <div class="no-data-msg">
                    <i class="fas fa-exclamation-triangle"></i>
                    Belum ada kelompok tani aktif yang terdaftar. Silakan hubungi admin koperasi untuk mendaftarkan kelompok tani Anda terlebih dahulu.
                </div>
            @endif
        </div>
    </div>

    {{-- ── Pilih BUMDes ── --}}
    <div class="select-group {{ old('jenis_anggota') === 'bumdes' ? 'show':'' }}" id="panelBumdes">
        <div class="select-box blue">
            <label><i class="fas fa-landmark" style="margin-right:6px;"></i> Pilih BUMDes <span class="req">*</span></label>
            @if($bumdes->isNotEmpty())
                <select name="bumdes_id" id="selBumdes"
                    class="{{ $errors->has('bumdes_id') ? 'is-invalid':'' }}">
                    <option value="">-- Pilih BUMDes Anda --</option>
                    @foreach($bumdes as $b)
                        <option value="{{ $b->id }}"
                            {{ old('bumdes_id') == $b->id ? 'selected':'' }}
                            data-lokasi="{{ $b->lokasi ?? implode(', ', array_filter([$b->desa_nama ?? '', $b->kabupaten_nama ?? ''])) }}">
                            {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
                @error('bumdes_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            @else
                <div class="no-data-msg">
                    <i class="fas fa-exclamation-triangle"></i>
                    Belum ada BUMDes aktif yang terdaftar. Silakan hubungi admin koperasi.
                </div>
            @endif
        </div>
    </div>

    {{-- ── Data Diri ── --}}
    <div class="card">
        <div class="card-head">
            <i class="fas fa-id-card"></i> Data Diri
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <label>Nama Lengkap (sesuai KTP) <span class="req">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                        class="{{ $errors->has('nama_lengkap') ? 'is-invalid':'' }}"
                        placeholder="Nama lengkap sesuai KTP" required>
                    @error('nama_lengkap')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col col-3">
                    <label>NIK <span class="req">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}"
                        class="{{ $errors->has('nik') ? 'is-invalid':'' }}"
                        maxlength="16" placeholder="16 digit NIK" required>
                    @error('nik')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col col-3">
                    <label>Tempat Lahir <span class="req">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                        class="{{ $errors->has('tempat_lahir') ? 'is-invalid':'' }}"
                        placeholder="Kota kelahiran" required>
                    @error('tempat_lahir')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col col-3">
                    <label>Tanggal Lahir <span class="req">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="{{ $errors->has('tanggal_lahir') ? 'is-invalid':'' }}" required>
                    @error('tanggal_lahir')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col col-2">
                    <label>Jenis Kelamin <span class="req">*</span></label>
                    <select name="jenis_kelamin" class="{{ $errors->has('jenis_kelamin') ? 'is-invalid':'' }}" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected':'' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected':'' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col col-2">
                    <label>Agama <span class="req">*</span></label>
                    <select name="agama" class="{{ $errors->has('agama') ? 'is-invalid':'' }}" required>
                        <option value="">-- Pilih --</option>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                            <option value="{{ $ag }}" {{ old('agama') === $ag ? 'selected':'' }}>{{ $ag }}</option>
                        @endforeach
                    </select>
                    @error('agama')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col col-2">
                    <label>No. Telepon / WhatsApp <span class="req">*</span></label>
                    <input type="tel" name="telepon" value="{{ old('telepon') }}"
                        class="{{ $errors->has('telepon') ? 'is-invalid':'' }}"
                        placeholder="cth: 08123456789" required>
                    @error('telepon')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col col-2">
                    <label>Email <span style="color:#9ca3af;font-weight:400;">(opsional)</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="{{ $errors->has('email') ? 'is-invalid':'' }}"
                        placeholder="email@contoh.com">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ── Alamat ── --}}
    <div class="card">
        <div class="card-head">
            <i class="fas fa-map-marker-alt"></i> Alamat (sesuai KTP)
        </div>
        <div class="card-body">
            <div style="margin-bottom:14px;">
                <label>Alamat Lengkap <span class="req">*</span></label>
                <textarea name="alamat_ktp" rows="2"
                    class="{{ $errors->has('alamat_ktp') ? 'is-invalid':'' }}"
                    placeholder="Nama jalan, RT/RW, dusun..." required>{{ old('alamat_ktp') }}</textarea>
                @error('alamat_ktp')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="wilayah-grid">
                <div>
                    <label>Provinsi</label>
                    <select name="provinsi_id_ktp" id="wil-provinsi" onchange="loadKabupaten(this.value)">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                    <input type="hidden" name="provinsi_ktp" id="wil-provinsi-nama" value="{{ old('provinsi_ktp') }}">
                </div>
                <div>
                    <label>Kabupaten / Kota</label>
                    <select name="kabupaten_id_ktp" id="wil-kabupaten" onchange="loadKecamatan(this.value)">
                        <option value="">-- Pilih Kabupaten --</option>
                    </select>
                    <input type="hidden" name="kabupaten_ktp" id="wil-kabupaten-nama" value="{{ old('kabupaten_ktp') }}">
                </div>
                <div>
                    <label>Kecamatan</label>
                    <select name="kecamatan_id_ktp" id="wil-kecamatan" onchange="loadDesa(this.value)">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                    <input type="hidden" name="kecamatan_ktp" id="wil-kecamatan-nama" value="{{ old('kecamatan_ktp') }}">
                </div>
                <div>
                    <label>Desa / Kelurahan</label>
                    <select name="desa_id_ktp" id="wil-desa" onchange="setNama('wil-desa-nama', this)">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                    <input type="hidden" name="desa_ktp" id="wil-desa-nama" value="{{ old('desa_ktp') }}">
                </div>
            </div>
        </div>
    </div>

    {{-- Submit --}}
    <div class="submit-wrap">
        <button type="submit" class="btn-submit">
            <i class="fas fa-paper-plane"></i>
            Kirim Pendaftaran
        </button>
        <p style="text-align:center;font-size:.78rem;color:#9ca3af;margin-top:12px;">
            <i class="fas fa-shield-alt" style="color:var(--green);"></i>
            Data Anda aman dan hanya digunakan untuk keperluan koperasi.
            Pendaftaran akan diverifikasi dalam 1–3 hari kerja.
        </p>
    </div>
    </form>
</div>

<script>
    // ── Type selector ──────────────────────────────────────────
    const typeCards = document.querySelectorAll('.type-card');
    const panelKelompok = document.getElementById('panelKelompok');
    const panelBumdes   = document.getElementById('panelBumdes');
    const selKelompok   = document.getElementById('selKelompok');
    const selBumdes     = document.getElementById('selBumdes');

    typeCards.forEach(card => {
        card.addEventListener('click', () => {
            typeCards.forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            const t = card.dataset.type;

            panelKelompok.classList.toggle('show', t === 'kelompok_tani');
            panelBumdes.classList.toggle('show', t === 'bumdes');

            // required management
            if (selKelompok) selKelompok.required = (t === 'kelompok_tani');
            if (selBumdes)   selBumdes.required   = (t === 'bumdes');
        });
    });

    // Init required dari old value
    (function() {
        const checked = document.querySelector('input[name=jenis_anggota]:checked');
        if (checked) {
            if (selKelompok) selKelompok.required = (checked.value === 'kelompok_tani');
            if (selBumdes)   selBumdes.required   = (checked.value === 'bumdes');
        }
    })();

    // Show kelompok tani info on select
    if (selKelompok) {
        selKelompok.addEventListener('change', function() {
            const opt = this.selectedOptions[0];
            const info = document.getElementById('ktInfo');
            if (opt && opt.value) {
                document.getElementById('ktLokasi').textContent = opt.dataset.lokasi || '-';
                document.getElementById('ktKetua').textContent  = opt.dataset.ketua  || '-';
                info.style.display = 'block';
            } else {
                info.style.display = 'none';
            }
        });
        // trigger on load if old value
        if (selKelompok.value) selKelompok.dispatchEvent(new Event('change'));
    }

    // ── Wilayah API ──────────────────────────────────────────
    const API = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    async function fetchJSON(url) {
        const r = await fetch(url);
        return r.json();
    }

    function fillSelect(sel, data, valKey, labelKey, selectedVal) {
        sel.innerHTML = '<option value="">-- Pilih --</option>';
        data.forEach(d => {
            const o = document.createElement('option');
            o.value = d[valKey];
            o.textContent = d[labelKey];
            if (String(d[valKey]) === String(selectedVal)) o.selected = true;
            sel.appendChild(o);
        });
    }

    function setNama(hiddenId, sel) {
        document.getElementById(hiddenId).value = sel.selectedOptions[0]?.textContent?.trim() || '';
    }

    async function loadProvinsi() {
        const data = await fetchJSON(API + '/provinces.json');
        const sel = document.getElementById('wil-provinsi');
        fillSelect(sel, data, 'id', 'name', '{{ old('provinsi_id_ktp') }}');
        document.getElementById('wil-provinsi-nama').value = sel.selectedOptions[0]?.textContent?.trim() || '';
        sel.addEventListener('change', function() {
            document.getElementById('wil-provinsi-nama').value = this.selectedOptions[0]?.textContent?.trim() || '';
            loadKabupaten(this.value);
        });
        if ('{{ old('provinsi_id_ktp') }}') loadKabupaten('{{ old('provinsi_id_ktp') }}');
    }

    async function loadKabupaten(pid) {
        if (!pid) { resetSelect('wil-kabupaten'); resetSelect('wil-kecamatan'); resetSelect('wil-desa'); return; }
        const data = await fetchJSON(API + '/regencies/' + pid + '.json');
        const sel = document.getElementById('wil-kabupaten');
        fillSelect(sel, data, 'id', 'name', '{{ old('kabupaten_id_ktp') }}');
        document.getElementById('wil-kabupaten-nama').value = sel.selectedOptions[0]?.textContent?.trim() || '';
        sel.addEventListener('change', function() {
            document.getElementById('wil-kabupaten-nama').value = this.selectedOptions[0]?.textContent?.trim() || '';
            loadKecamatan(this.value);
        });
        if ('{{ old('kabupaten_id_ktp') }}') loadKecamatan('{{ old('kabupaten_id_ktp') }}');
    }

    async function loadKecamatan(kid) {
        if (!kid) { resetSelect('wil-kecamatan'); resetSelect('wil-desa'); return; }
        const data = await fetchJSON(API + '/districts/' + kid + '.json');
        const sel = document.getElementById('wil-kecamatan');
        fillSelect(sel, data, 'id', 'name', '{{ old('kecamatan_id_ktp') }}');
        document.getElementById('wil-kecamatan-nama').value = sel.selectedOptions[0]?.textContent?.trim() || '';
        sel.addEventListener('change', function() {
            document.getElementById('wil-kecamatan-nama').value = this.selectedOptions[0]?.textContent?.trim() || '';
            loadDesa(this.value);
        });
        if ('{{ old('kecamatan_id_ktp') }}') loadDesa('{{ old('kecamatan_id_ktp') }}');
    }

    async function loadDesa(cid) {
        if (!cid) { resetSelect('wil-desa'); return; }
        const data = await fetchJSON(API + '/villages/' + cid + '.json');
        const sel = document.getElementById('wil-desa');
        fillSelect(sel, data, 'id', 'name', '{{ old('desa_id_ktp') }}');
        document.getElementById('wil-desa-nama').value = sel.selectedOptions[0]?.textContent?.trim() || '';
        sel.addEventListener('change', function() {
            document.getElementById('wil-desa-nama').value = this.selectedOptions[0]?.textContent?.trim() || '';
        });
    }

    function resetSelect(id) {
        const sel = document.getElementById(id);
        sel.innerHTML = '<option value="">-- Pilih --</option>';
    }

    loadProvinsi();
</script>
</body>
</html>
