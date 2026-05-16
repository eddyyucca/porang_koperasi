<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ config('app.name') }}</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- AdminLTE 3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Leaflet CSS (peta) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <style>
        :root {
            --porang-green: #2e7d32;
            --porang-light: #4caf50;
            --porang-dark:  #1b5e20;
            --porang-sidebar: #18263f;
            --porang-sidebar-soft: #223454;
            --porang-border: rgba(255,255,255,0.08);
        }
        body { font-size: 0.95rem; }
        .main-header {
            background: linear-gradient(90deg, var(--porang-dark), var(--porang-green)) !important;
            border-bottom: 0;
            box-shadow: 0 6px 18px rgba(27, 94, 32, 0.18);
        }
        .main-header .navbar-nav .nav-link {
            color: #fff !important;
            border-radius: 10px;
            padding: 0.55rem 0.8rem;
        }
        .main-header .navbar-nav .nav-link:hover {
            background: rgba(255,255,255,0.12);
        }
        .main-sidebar {
            background: linear-gradient(180deg, var(--porang-sidebar) 0%, #101b2f 100%) !important;
            box-shadow: 6px 0 20px rgba(0,0,0,0.12);
        }
        .main-sidebar .nav-link {
            color: #d6e2f2 !important;
            border-radius: 12px;
            margin: 0.15rem 0.75rem;
            padding: 0.75rem 0.9rem;
            transition: all 0.2s ease;
        }
        .main-sidebar .nav-link:hover,
        .main-sidebar .nav-link.active {
            color: #fff !important;
            background: linear-gradient(90deg, rgba(76,175,80,0.32), rgba(76,175,80,0.18)) !important;
            box-shadow: inset 0 0 0 1px rgba(129,199,132,0.18);
        }
        .main-sidebar .nav-link .nav-icon {
            width: 1.35rem;
            text-align: center;
            margin-right: 0.35rem;
        }
        .main-sidebar .brand-link {
            background: rgba(14, 24, 42, 0.65) !important;
            border-bottom: 1px solid var(--porang-border);
            height: 64px;
            display: flex;
            align-items: center;
        }
        .brand-text { color: #fff !important; font-weight: 700 !important; }
        .brand-image {
            margin: 0 0.85rem 0 1rem !important;
        }
        .sidebar-mini.sidebar-collapse .main-sidebar .brand-text {
            display: none;
        }
        .sidebar {
            padding-bottom: 1rem;
        }
        .user-panel {
            margin: 1rem 0.85rem 0.75rem !important;
            padding: 0.9rem 0.95rem !important;
            border-radius: 14px;
            background: rgba(255,255,255,0.05);
            border-bottom: 0 !important;
        }
        .user-panel .image {
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-panel .info {
            padding-left: 0.75rem !important;
        }
        .nav-sidebar .nav-header {
            font-size: 0.68rem !important;
            letter-spacing: 0.08em;
            color: #7f93b7 !important;
            padding: 1rem 1.5rem 0.45rem !important;
        }
        .nav-sidebar .nav-treeview > .nav-item > .nav-link { padding-left: 2.5rem !important; }
        .nav-sidebar .badge.right {
            right: 0.85rem;
            top: 0.9rem;
        }

        /* Badge status */
        .badge-aktif    { background: #28a745; }
        .badge-pending  { background: #ffc107; color: #333; }
        .badge-nonaktif { background: #dc3545; }

        /* Card porang theme */
        .card-header-porang { background: var(--porang-green); color: #fff; }

        /* Peta */
        #map-dashboard { height: 420px; border-radius: 8px; }
        #map-lahan { height: 380px; border-radius: 8px; }
        #map-picker { height: 320px; border-radius: 8px; }
        .chart-box {
            position: relative;
            min-height: 320px;
        }
        .chart-box.chart-box-sm {
            min-height: 280px;
        }
        .chart-empty {
            min-height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #6c757d;
            border: 1px dashed #d7dee7;
            border-radius: 12px;
            background: linear-gradient(180deg, #fbfcfd 0%, #f3f6f9 100%);
            padding: 1rem;
        }
        .dashboard-table-card .card-header,
        .dashboard-chart-card .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dashboard-table-card .card-title,
        .dashboard-chart-card .card-title {
            margin-bottom: 0;
        }

        /* Info boxes */
        .info-box .info-box-icon { background: rgba(0,0,0,0.15); }
        .info-box-green  { background: #28a745 !important; color: #fff; }
        .info-box-blue   { background: #17a2b8 !important; color: #fff; }
        .info-box-orange { background: #fd7e14 !important; color: #fff; }
        .info-box-purple { background: #6f42c1 !important; color: #fff; }
        .info-box .info-box-content .info-box-number { font-size: 1.6rem; font-weight: 700; }

        /* Responsive tabel */
        @media (max-width: 576px) {
            .card-body { padding: 0.75rem; }
            .info-box-number { font-size: 1.2rem !important; }
            .main-sidebar .nav-link {
                margin-left: 0.5rem;
                margin-right: 0.5rem;
            }
            .user-panel {
                margin-left: 0.5rem !important;
                margin-right: 0.5rem !important;
            }
        }

        .content-wrapper { background: #f4f6f9; }
        .content-header {
            padding-top: 1rem;
        }
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 0;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            color: #9aa5b1;
        }
        .card {
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }
        .card-header-porang {
            padding: 0.95rem 1.15rem;
        }
        .table thead th {
            border-bottom: 0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #5f6b7a;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-seedling me-1"></i> Koperasi Barakat Pangan Banua
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('anggota.create') }}" title="Tambah Anggota">
                    <i class="fas fa-user-plus"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i>
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <span class="dropdown-item-text text-muted small">{{ Auth::user()->email }}</span>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-success elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i class="fas fa-seedling brand-image" style="font-size:1.6rem; color:#81c784; margin: 8px 12px;"></i>
            <span class="brand-text font-weight-light">Tani Porang</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-secondary"></i>
                </div>
                <div class="info">
                    <a href="#" class="d-block text-white">{{ Auth::user()->name }}</a>
                    <small class="text-secondary text-capitalize">{{ Auth::user()->role }}</small>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase">Data Koperasi</li>

                    <li class="nav-item">
                        <a href="{{ route('koperasi.index') }}" class="nav-link {{ request()->routeIs('koperasi.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Data Koperasi</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('bumdes.index') }}" class="nav-link {{ request()->routeIs('bumdes.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-landmark"></i>
                            <p>Data BUMDes</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kelompok-tani.index') }}" class="nav-link {{ request()->routeIs('kelompok-tani.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-people-group"></i>
                            <p>Kelompok Tani</p>
                            @php $pendingKT = \App\Models\KelompokTani::where('status','pending')->count() @endphp
                            @if($pendingKT > 0)
                                <span class="badge badge-warning right">{{ $pendingKT }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('anggota.index') }}" class="nav-link {{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Petani</p>
                            @php $pending = \App\Models\Anggota::where('status','pending')->count() @endphp
                            @if($pending > 0)
                                <span class="badge badge-warning right">{{ $pending }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-header text-uppercase">Data Pertanian</li>

                    <li class="nav-item">
                        <a href="{{ route('lahan.index') }}" class="nav-link {{ request()->routeIs('lahan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>Data Lahan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('tanaman.index') }}" class="nav-link {{ request()->routeIs('tanaman.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-seedling"></i>
                            <p>Data Penanaman</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('panen.index') }}" class="nav-link {{ request()->routeIs('panen.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>Data Panen</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase">Sistem</li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}#peta" class="nav-link">
                            <i class="nav-icon fas fa-globe-asia"></i>
                            <p>Peta GIS</p>
                        </a>
                    </li>

                    @if(Auth::user()->isSuperAdmin())
                    <li class="nav-header text-uppercase">Super Admin</li>

                    <li class="nav-item">
                        <a href="{{ route('dokumen-pdf.index') }}" class="nav-link {{ request()->routeIs('dokumen-pdf.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-pdf" style="color:#ef5350;"></i>
                            <p>Dokumen PDF</p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="font-size:1.3rem; font-weight:600;">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">

                {{-- Alert pesan --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong><i class="fas fa-exclamation-triangle me-1"></i> Terjadi Kesalahan:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @yield('content')

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer text-sm">
        <div class="float-right d-none d-sm-block">
            <b>Versi</b> 1.0.0
        </div>
        <strong>Sistem Informasi Koperasi Barakat Pangan Banua</strong>
        &copy; {{ date('Y') }}
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE 3 -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Init Select2 global
    $(function () {
        $('[data-select2]').select2({ theme: 'bootstrap4', width: '100%' });
        // Auto dismiss alerts
        setTimeout(function() { $('.alert').alert('close'); }, 5000);
    });
</script>
@stack('scripts')
</body>
</html>
