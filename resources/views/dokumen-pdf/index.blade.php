@extends('layouts.app')

@section('title', 'Dokumen PDF')
@section('page-title', 'Manajemen Dokumen PDF')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dokumen PDF</li>
@endsection

@push('styles')
<style>
    .upload-zone {
        border: 2.5px dashed #4caf50;
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
        background: #f0faf0;
        transition: all .25s;
        cursor: pointer;
    }
    .upload-zone:hover, .upload-zone.dragover {
        background: #e0f5e0;
        border-color: #2e7d32;
    }
    .upload-zone i { font-size: 2.5rem; color: #4caf50; margin-bottom: 10px; display: block; }
    .upload-zone p { color: #555; margin: 0; font-size: .92rem; }
    .upload-zone small { color: #9ca3af; font-size: .78rem; }
    .file-preview {
        display: none;
        align-items: center;
        gap: 12px;
        background: #e8f5e9;
        border: 1.5px solid #4caf50;
        border-radius: 10px;
        padding: 12px 16px;
        margin-top: 10px;
    }
    .file-preview.show { display: flex; }
    .file-preview i { font-size: 1.6rem; color: #e53935; flex-shrink: 0; }
    .file-preview .fname { font-weight: 600; font-size: .88rem; color: #1b5e20; }
    .file-preview .fsize { font-size: .78rem; color: #6b7280; }
    .pdf-row td { vertical-align: middle; }
    .pdf-icon { color: #e53935; font-size: 1.3rem; }
    .badge-superadmin { background: linear-gradient(135deg,#6f42c1,#9c27b0); color:#fff; padding:3px 10px; border-radius:50px; font-size:.7rem; font-weight:700; letter-spacing:.05em; }
</style>
@endpush

@section('content')

{{-- Upload Form --}}
<div class="card mb-4">
    <div class="card-header card-header-porang d-flex align-items-center gap-2">
        <h3 class="card-title mb-0"><i class="fas fa-file-upload me-2"></i> Unggah Dokumen PDF</h3>
        <span class="badge-superadmin ml-auto"><i class="fas fa-shield-alt me-1"></i>Super Admin</span>
    </div>
    <div class="card-body">
        <form action="{{ route('dokumen-pdf.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf
        <div class="row">
            <div class="col-md-5 mb-3">
                <label class="font-weight-bold">Nama Dokumen <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama') }}"
                    placeholder="cth: Laporan Keuangan Q1 2025"
                    required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-7 mb-3">
                <label class="font-weight-bold">Deskripsi <span class="text-muted font-weight-normal">(opsional)</span></label>
                <input type="text" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                    value="{{ old('deskripsi') }}"
                    placeholder="Keterangan singkat dokumen">
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="font-weight-bold">File PDF <span class="text-danger">*</span></label>
            <input type="file" name="file" id="fileInput" accept=".pdf" class="d-none @error('file') is-invalid @enderror" required>
            <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p><strong>Klik untuk pilih file</strong> atau seret & lepas di sini</p>
                <small>Format: PDF &bull; Maks. 20 MB</small>
            </div>
            <div class="file-preview" id="filePreview">
                <i class="fas fa-file-pdf"></i>
                <div>
                    <div class="fname" id="previewName">-</div>
                    <div class="fsize" id="previewSize">-</div>
                </div>
                <button type="button" class="btn btn-xs btn-outline-danger ml-auto" onclick="clearFile()">
                    <i class="fas fa-times"></i> Hapus
                </button>
            </div>
            @error('file')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-success" id="btnUpload">
            <i class="fas fa-upload me-1"></i> Unggah Dokumen
        </button>
        </form>
    </div>
</div>

{{-- Daftar Dokumen --}}
<div class="card">
    <div class="card-header card-header-porang d-flex align-items-center gap-2">
        <h3 class="card-title mb-0"><i class="fas fa-folder-open me-2"></i> Daftar Dokumen</h3>
        <span class="ml-auto text-white-50 small">{{ $dokumen->total() }} dokumen</span>
    </div>

    {{-- Search --}}
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Cari nama dokumen..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm btn-block">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
            @if(request('search'))
            <div class="col-md-2">
                <a href="{{ route('dokumen-pdf.index') }}" class="btn btn-secondary btn-sm btn-block">Reset</a>
            </div>
            @endif
        </form>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="40">#</th>
                        <th>Nama Dokumen</th>
                        <th>Deskripsi</th>
                        <th width="90">Ukuran</th>
                        <th width="130">Diunggah</th>
                        <th width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokumen as $doc)
                    <tr class="pdf-row">
                        <td class="text-muted small">{{ $loop->iteration + ($dokumen->currentPage() - 1) * $dokumen->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf pdf-icon"></i>
                                <div>
                                    <div class="font-weight-bold" style="font-size:.9rem;">{{ $doc->nama }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">{{ $doc->deskripsi ?: '-' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-light border" style="font-size:.78rem;">
                                {{ $doc->ukuran_format }}
                            </span>
                        </td>
                        <td>
                            <span class="small text-muted">{{ $doc->created_at->format('d/m/Y') }}</span>
                            <br><span class="small text-muted">{{ $doc->created_at->format('H:i') }}</span>
                        </td>
                        <td>
                            <a href="{{ route('dokumen-pdf.download', $doc) }}"
                               class="btn btn-xs btn-success mr-1" title="Download">
                                <i class="fas fa-download"></i>
                            </a>
                            <form action="{{ route('dokumen-pdf.destroy', $doc) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus dokumen \"{{ addslashes($doc->nama) }}\"?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block" style="opacity:.3;"></i>
                            Belum ada dokumen yang diunggah
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($dokumen->hasPages())
    <div class="card-footer">
        {{ $dokumen->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    const fileInput  = document.getElementById('fileInput');
    const uploadZone = document.getElementById('uploadZone');
    const filePreview = document.getElementById('filePreview');
    const previewName = document.getElementById('previewName');
    const previewSize = document.getElementById('previewSize');

    fileInput.addEventListener('change', function() {
        showPreview(this.files[0]);
    });

    // Drag & drop
    uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
    uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
    uploadZone.addEventListener('drop', e => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type === 'application/pdf') {
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            showPreview(file);
        }
    });

    function showPreview(file) {
        if (!file) return;
        previewName.textContent = file.name;
        previewSize.textContent = formatBytes(file.size);
        uploadZone.style.display = 'none';
        filePreview.classList.add('show');
    }

    function clearFile() {
        fileInput.value = '';
        filePreview.classList.remove('show');
        uploadZone.style.display = '';
    }

    function formatBytes(bytes) {
        if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
        if (bytes >= 1024)    return (bytes / 1024).toFixed(1)    + ' KB';
        return bytes + ' B';
    }

    // Submit guard
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('btnUpload');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengunggah...';
    });
</script>
@endpush
