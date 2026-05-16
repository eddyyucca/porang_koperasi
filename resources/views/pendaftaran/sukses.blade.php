<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil | Koperasi Barakat Pangan Banua</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --green-dark:#1a4d2e; --green:#2d6a2d; --green-mid:#3a7d44; --green-pale:#d4edda; --yellow:#f5c518; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'Poppins',sans-serif; background:linear-gradient(135deg,#e8f5e9,#faf7f2); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
        .card { background:#fff; border-radius:24px; box-shadow:0 20px 60px rgba(0,0,0,.12); max-width:520px; width:100%; padding:48px 36px; text-align:center; }
        .icon { width:96px; height:96px; background:linear-gradient(135deg,var(--green-mid),var(--green-dark)); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px; box-shadow:0 12px 32px rgba(45,106,45,.35); animation:pop .5s cubic-bezier(.36,1.5,.64,1); }
        @keyframes pop { from{transform:scale(0);opacity:0} to{transform:scale(1);opacity:1} }
        .badge { display:inline-flex; align-items:center; gap:6px; background:#fff3cd; color:#856404; border:1px solid #ffc107; border-radius:50px; padding:6px 16px; font-size:.8rem; font-weight:600; margin-bottom:18px; }
        h1 { font-size:1.6rem; font-weight:700; color:var(--green-dark); margin-bottom:10px; }
        .sub { font-size:.92rem; color:#6b7280; line-height:1.7; margin-bottom:24px; }
        .steps { background:var(--green-pale); border-radius:12px; padding:18px; text-align:left; margin-bottom:24px; }
        .steps h4 { font-size:.85rem; font-weight:700; color:var(--green-dark); margin-bottom:12px; }
        .step { display:flex; align-items:flex-start; gap:10px; margin-bottom:8px; }
        .step:last-child { margin-bottom:0; }
        .step-n { width:22px; height:22px; border-radius:50%; background:var(--green); color:#fff; font-size:.7rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }
        .step p { font-size:.82rem; color:#374151; line-height:1.5; }
        .actions { display:flex; flex-direction:column; gap:10px; }
        .btn { display:flex; align-items:center; justify-content:center; gap:8px; padding:13px 24px; border-radius:50px; font-family:'Poppins',sans-serif; font-size:.92rem; font-weight:600; text-decoration:none; border:none; cursor:pointer; transition:all .3s; }
        .btn-primary { background:linear-gradient(135deg,var(--green-mid),var(--green-dark)); color:#fff; box-shadow:0 6px 20px rgba(45,106,45,.3); }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(45,106,45,.4); }
        .btn-outline { background:transparent; color:var(--green); border:2px solid var(--green); }
        .btn-outline:hover { background:var(--green-pale); }
    </style>
</head>
<body>
<div class="card">
    <div class="icon">
        <i class="fas fa-check" style="font-size:2.2rem;color:#fff;"></i>
    </div>
    <div class="badge"><i class="fas fa-clock"></i> Menunggu Verifikasi</div>
    <h1>Pendaftaran Diterima!</h1>
    <p class="sub">Data Anda telah kami terima. Tim koperasi akan segera memverifikasi dan menghubungi Anda melalui nomor telepon yang didaftarkan.</p>
    <div class="steps">
        <h4><i class="fas fa-list-ol" style="margin-right:6px;"></i>Langkah Selanjutnya</h4>
        <div class="step">
            <div class="step-n">1</div>
            <p>Tim koperasi memverifikasi data Anda dalam <strong>1–3 hari kerja</strong>.</p>
        </div>
        <div class="step">
            <div class="step-n">2</div>
            <p>Anda akan dihubungi via <strong>telepon/WhatsApp</strong> untuk konfirmasi dan kelengkapan dokumen.</p>
        </div>
        <div class="step">
            <div class="step-n">3</div>
            <p>Setelah disetujui, Anda resmi jadi anggota dan dapat mengakses seluruh layanan koperasi.</p>
        </div>
    </div>
    <div class="actions">
        <a href="{{ route('daftar') }}" class="btn btn-outline">
            <i class="fas fa-plus"></i> Daftarkan Anggota Lain
        </a>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</div>
</body>
</html>
