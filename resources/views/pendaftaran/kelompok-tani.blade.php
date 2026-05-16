<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelompok Tani | Koperasi Barakat Pangan Banua</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --green-dark: #1a4d2e;
            --green:      #2d6a2d;
            --green-mid:  #3a7d44;
            --green-pale: #d4edda;
            --yellow:     #f5c518;
            --cream:      #faf7f2;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            min-height: 100vh;
        }
        .page-header {
            background: linear-gradient(135deg, var(--green-dark), var(--green-mid));
            color: #fff;
            padding: 24px 0;
            text-align: center;
        }
        .page-header .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }
        .logo-icon {
            width: 44px; height: 44px;
            background: var(--yellow);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: var(--green-dark);
        }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; }
        .page-header p  { font-size: .88rem; opacity: .8; margin-top: 4px; }
        .container {
            max-width: 860px;
            margin: 0 auto;
            padding: 32px 16px 60px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,.07);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card-head {
            background: var(--green);
            color: #fff;
            padding: 14px 20px;
            font-weight: 600;
            font-size: .95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-body { padding: 20px; }
        .row { display: flex; flex-wrap: wrap; margin: 0 -8px; }
        .col { padding: 0 8px; margin-bottom: 14px; flex: 1 1 100%; }
        .col-2 { flex: 1 1 calc(50% - 16px); min-width: 200px; }
        .col-3 { flex: 1 1 calc(33.33% - 16px); min-width: 160px; }
        label { display: block; font-size: .83rem; font-weight: 600; color: #374151; margin-bottom: 5px; }
        label .req { color: #dc3545; }
        input[type=text], input[type=number], input[type=tel], input[type=file],
        select, textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: .88rem;
            color: #111;
            transition: border-color .2s;
            background: #fafafa;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--green-mid);
            background: #fff;
        }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { color: #dc3545; font-size: .78rem; margin-top: 3px; }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
            color: #fff;
            border: none;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 24px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(45,106,45,.4); }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--green);
            font-size: .88rem;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .btn-back:hover { color: var(--green-dark); }
        .notice {
            background: var(--green-pale);
            border-left: 4px solid var(--green);
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            font-size: .85rem;
            color: var(--green-dark);
            margin-bottom: 20px;
        }
        .alert-error {
            background: #fee2e2;
            border-left: 4px solid #dc3545;
            border-radius: 0 8px 8px 0;
            padding: 12px 16px;
            font-size: .85rem;
            color: #7f1d1d;
            margin-bottom: 20px;
        }
        @media (max-width: 600px) {
            .col-2, .col-3 { flex: 1 1 100%; }
        }
        /* Wilayah dropdowns */
        .wilayah-row { display: flex; flex-wrap: wrap; gap: 0 16px; }
        .wilayah-col { flex: 1 1 calc(50% - 8px); min-width: 200px; margin-bottom: 14px; }
        @media (max-width: 600px) { .wilayah-col { flex: 1 1 100%; } }
    </style>
</head>
<body>

<div class="page-header">
    <div class="logo">
        <div class="logo-icon"><i class="fas fa-seedling"></i></div>
        <div>
            <div style="font-weight:700;font-size:1.1rem;">Koperasi Barakat Pangan Banua</div>
            <div style="font-size:.72rem;opacity:.8;letter-spacing:.05em;text-transform:uppercase;">Pendaftaran Kelompok Tani</div>
        </div>
    </div>
    <p>Daftarkan kelompok tani Anda untuk bergabung bersama kami</p>
</div>

<div class="container">
    <a href="{{ route('home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="notice">
        <strong><i class="fas fa-info-circle me-1"></i> Informasi:</strong>
        Pendaftaran kelompok tani akan diverifikasi oleh tim koperasi dalam 1–3 hari kerja.
        Setelah diverifikasi, ketua kelompok akan dihubungi melalui nomor telepon yang didaftarkan.
    </div>

    @if($errors->any())
    <div class="alert-error">
        <strong><i class="fas fa-exclamation-triangle"></i> Mohon periksa kembali data Anda:</strong>
        <ul style="margin:6px 0 0 16px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('daftar.kelompok.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Informasi Kelompok --}}
    <div class="card">
        <div class="card-head">
            <i class="fas fa-people-group"></i> Informasi Kelompok Tani
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <label>Nama Kelompok Tani <span class="req">*</span></label>
                    <input type="text" name="nama_kelompok" value="{{ old('nama_kelompok') }}"
                        class="{{ $errors->has('nama_kelompok') ? 'is-invalid':'' }}"
                        placeholder="cth: Kelompok Tani Maju Bersama" required>
                    @error('nama_kelompok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col col-3">
                    <label>Nomor SK Pembentukan</label>
                    <input type="text" name="nomor_sk" value="{{ old('nomor_sk') }}"
                        class="{{ $errors->has('nomor_sk') ? 'is-invalid':'' }}"
                        placeholder="No. SK (jika ada)">
                    @error('nomor_sk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col col-3">
                    <label>Tahun Berdiri</label>
                    <input type="number" name="tahun_berdiri" value="{{ old('tahun_berdiri') }}"
                        class="{{ $errors->has('tahun_berdiri') ? 'is-invalid':'' }}"
                        min="1900" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                    @error('tahun_berdiri')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col col-3">
                    <label>Jumlah Anggota</label>
                    <input type="number" name="jumlah_anggota" value="{{ old('jumlah_anggota') }}"
                        class="{{ $errors->has('jumlah_anggota') ? 'is-invalid':'' }}"
                        min="1" placeholder="Perkiraan jumlah">
                    @error('jumlah_anggota')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col col-2">
                    <label>Komoditas Utama</label>
                    <input type="text" name="komoditas_utama" value="{{ old('komoditas_utama', 'Porang') }}"
                        class="{{ $errors->has('komoditas_utama') ? 'is-invalid':'' }}">
                    @error('komoditas_utama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col col-2">
                    <label>Total Lahan (m²)</label>
                    <input type="number" name="luas_lahan_total" value="{{ old('luas_lahan_total') }}"
                        class="{{ $errors->has('luas_lahan_total') ? 'is-invalid':'' }}"
                        min="0" step="0.01" placeholder="Perkiraan total lahan">
                    @error('luas_lahan_total')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            @if($bumdes->isNotEmpty())
            <div class="row">
                <div class="col col-2">
                    <label>BUMDes (jika ada)</label>
                    <select name="bumdes_id" class="{{ $errors->has('bumdes_id') ? 'is-invalid':'' }}">
                        <option value="">-- Pilih BUMDes --</option>
                        @foreach($bumdes as $b)
                            <option value="{{ $b->id }}" {{ old('bumdes_id') == $b->id ? 'selected':'' }}>
                                {{ $b->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('bumdes_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col col-2">
                    <label>Foto Kelompok (opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                        class="{{ $errors->has('foto') ? 'is-invalid':'' }}">
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            @else
            <div class="row">
                <div class="col">
                    <label>Foto Kelompok (opsional)</label>
                    <input type="file" name="foto" accept="image/*"
                        class="{{ $errors->has('foto') ? 'is-invalid':'' }}">
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Data Pengurus --}}
    <div class="card">
        <div class="card-head">
            <i class="fas fa-user-tie"></i> Data Pengurus Kelompok
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col col-3">
                    <label>Nama Ketua <span class="req">*</span></label>
                    <input type="text" name="ketua_nama" value="{{ old('ketua_nama') }}"
                        class="{{ $errors->has('ketua_nama') ? 'is-invalid':'' }}" required>
                    @error('ketua_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col col-3">
                    <label>NIK Ketua</label>
                    <input type="text" name="ketua_nik" value="{{ old('ketua_nik') }}"
                        class="{{ $errors->has('ketua_nik') ? 'is-invalid':'' }}"
                        maxlength="16" placeholder="16 digit NIK">
                    @error('ketua_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col col-3">
                    <label>Telepon Ketua <span class="req">*</span></label>
                    <input type="tel" name="ketua_telepon" value="{{ old('ketua_telepon') }}"
                        class="{{ $errors->has('ketua_telepon') ? 'is-invalid':'' }}"
                        placeholder="cth: 0812xxxxxxxx" required>
                    @error('ketua_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col col-2">
                    <label>Sekretaris</label>
                    <input type="text" name="sekretaris" value="{{ old('sekretaris') }}"
                        class="{{ $errors->has('sekretaris') ? 'is-invalid':'' }}">
                    @error('sekretaris')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col col-2">
                    <label>Bendahara</label>
                    <input type="text" name="bendahara" value="{{ old('bendahara') }}"
                        class="{{ $errors->has('bendahara') ? 'is-invalid':'' }}">
                    @error('bendahara')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Lokasi --}}
    <div class="card">
        <div class="card-head">
            <i class="fas fa-map-marker-alt"></i> Lokasi Kelompok Tani
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="2"
                        class="{{ $errors->has('alamat') ? 'is-invalid':'' }}"
                        placeholder="Jalan, RT/RW, dusun...">{{ old('alamat') }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Wilayah manual (tanpa component AdminLTE) --}}
            <div class="wilayah-row">
                <div class="wilayah-col">
                    <label>Provinsi</label>
                    <select name="provinsi_id" id="reg-provinsi" onchange="loadKabupaten(this.value)">
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                    <input type="hidden" name="provinsi_nama" id="reg-provinsi-nama" value="{{ old('provinsi_nama') }}">
                </div>
                <div class="wilayah-col">
                    <label>Kabupaten / Kota</label>
                    <select name="kabupaten_id" id="reg-kabupaten" onchange="loadKecamatan(this.value)">
                        <option value="">-- Pilih Kabupaten --</option>
                    </select>
                    <input type="hidden" name="kabupaten_nama" id="reg-kabupaten-nama" value="{{ old('kabupaten_nama') }}">
                </div>
                <div class="wilayah-col">
                    <label>Kecamatan</label>
                    <select name="kecamatan_id" id="reg-kecamatan" onchange="loadDesa(this.value)">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                    <input type="hidden" name="kecamatan_nama" id="reg-kecamatan-nama" value="{{ old('kecamatan_nama') }}">
                </div>
                <div class="wilayah-col">
                    <label>Desa / Kelurahan</label>
                    <select name="desa_id" id="reg-desa" onchange="setDesaNama(this)">
                        <option value="">-- Pilih Desa --</option>
                    </select>
                    <input type="hidden" name="desa_nama" id="reg-desa-nama" value="{{ old('desa_nama') }}">
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-paper-plane"></i>
        Kirim Pendaftaran Kelompok Tani
    </button>
    </form>
</div>

<script>
    const API = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    async function fetchJSON(url) {
        const r = await fetch(url);
        return r.json();
    }

    function setOption(sel, data, valKey, labelKey, selectedVal) {
        sel.innerHTML = '<option value="">-- Pilih --</option>';
        data.forEach(d => {
            const o = document.createElement('option');
            o.value = d[valKey];
            o.textContent = d[labelKey];
            if (d[valKey] == selectedVal) o.selected = true;
            sel.appendChild(o);
        });
    }

    async function loadProvinsi() {
        const data = await fetchJSON(API + '/provinces.json');
        setOption(document.getElementById('reg-provinsi'), data, 'id', 'name', '{{ old('provinsi_id') }}');
        if ('{{ old('provinsi_id') }}') loadKabupaten('{{ old('provinsi_id') }}');
    }

    async function loadKabupaten(pid) {
        document.getElementById('reg-provinsi-nama').value =
            document.getElementById('reg-provinsi').selectedOptions[0]?.textContent || '';
        if (!pid) return;
        const data = await fetchJSON(API + '/regencies/' + pid + '.json');
        setOption(document.getElementById('reg-kabupaten'), data, 'id', 'name', '{{ old('kabupaten_id') }}');
        if ('{{ old('kabupaten_id') }}') loadKecamatan('{{ old('kabupaten_id') }}');
    }

    async function loadKecamatan(kid) {
        document.getElementById('reg-kabupaten-nama').value =
            document.getElementById('reg-kabupaten').selectedOptions[0]?.textContent || '';
        if (!kid) return;
        const data = await fetchJSON(API + '/districts/' + kid + '.json');
        setOption(document.getElementById('reg-kecamatan'), data, 'id', 'name', '{{ old('kecamatan_id') }}');
        if ('{{ old('kecamatan_id') }}') loadDesa('{{ old('kecamatan_id') }}');
    }

    async function loadDesa(cid) {
        document.getElementById('reg-kecamatan-nama').value =
            document.getElementById('reg-kecamatan').selectedOptions[0]?.textContent || '';
        if (!cid) return;
        const data = await fetchJSON(API + '/villages/' + cid + '.json');
        setOption(document.getElementById('reg-desa'), data, 'id', 'name', '{{ old('desa_id') }}');
    }

    function setDesaNama(sel) {
        document.getElementById('reg-desa-nama').value = sel.selectedOptions[0]?.textContent || '';
    }

    loadProvinsi();
</script>
</body>
</html>
