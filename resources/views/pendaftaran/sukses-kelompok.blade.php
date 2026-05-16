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
        :root {
            --green-dark: #1a4d2e;
            --green:      #2d6a2d;
            --green-mid:  #3a7d44;
            --green-pale: #d4edda;
            --yellow:     #f5c518;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 50%, #faf7f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,.12);
            max-width: 540px;
            width: 100%;
            padding: 48px 40px;
            text-align: center;
        }
        .icon-wrap {
            width: 96px; height: 96px;
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 12px 32px rgba(45,106,45,.35);
            animation: pop .5s cubic-bezier(.36,1.5,.64,1);
        }
        @keyframes pop {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }
        h1 {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 12px;
        }
        .subtitle {
            font-size: .95rem;
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 28px;
        }
        .steps {
            background: var(--green-pale);
            border-radius: 12px;
            padding: 20px;
            text-align: left;
            margin-bottom: 28px;
        }
        .steps h4 {
            font-size: .88rem;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 12px;
        }
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 10px;
        }
        .step-item:last-child { margin-bottom: 0; }
        .step-num {
            width: 24px; height: 24px;
            background: var(--green);
            color: #fff;
            border-radius: 50%;
            font-size: .72rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .step-text { font-size: .84rem; color: #374151; line-height: 1.5; }
        .actions { display: flex; flex-direction: column; gap: 10px; }
        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 24px;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-size: .92rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all .3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--green-mid), var(--green-dark));
            color: #fff;
            box-shadow: 0 6px 20px rgba(45,106,45,.3);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(45,106,45,.4); }
        .btn-outline {
            background: transparent;
            color: var(--green);
            border: 2px solid var(--green);
        }
        .btn-outline:hover { background: var(--green-pale); }
        .badge-pending {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
            border-radius: 50px;
            padding: 6px 16px;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="icon-wrap">
        <i class="fas fa-check" style="font-size:2.2rem;color:#fff;"></i>
    </div>

    <div class="badge-pending">
        <i class="fas fa-clock"></i> Menunggu Verifikasi
    </div>

    <h1>Pendaftaran Berhasil!</h1>
    <p class="subtitle">
        Terima kasih telah mendaftarkan kelompok tani Anda.
        Data Anda telah kami terima dan akan segera diverifikasi oleh tim koperasi.
    </p>

    <div class="steps">
        <h4><i class="fas fa-list-ol me-2"></i>Apa selanjutnya?</h4>
        <div class="step-item">
            <div class="step-num">1</div>
            <div class="step-text">Tim koperasi akan memverifikasi data kelompok tani Anda dalam <strong>1–3 hari kerja</strong>.</div>
        </div>
        <div class="step-item">
            <div class="step-num">2</div>
            <div class="step-text">Ketua kelompok akan dihubungi melalui nomor telepon yang didaftarkan untuk konfirmasi.</div>
        </div>
        <div class="step-item">
            <div class="step-num">3</div>
            <div class="step-text">Setelah disetujui, kelompok tani Anda akan aktif dan dapat mengakses seluruh layanan koperasi.</div>
        </div>
    </div>

    <div class="actions">
        <a href="{{ route('daftar.kelompok') }}" class="btn btn-outline">
            <i class="fas fa-plus"></i> Daftarkan Kelompok Lain
        </a>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</div>
</body>
</html>
