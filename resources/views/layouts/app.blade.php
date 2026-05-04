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
        }
        .main-header { background: var(--porang-green) !important; }
        .main-header .navbar-nav .nav-link { color: #fff !important; }
        .main-sidebar { background: #1a2744 !important; }
        .main-sidebar .nav-link { color: #c8d3e8 !important; }
        .main-sidebar .nav-link:hover,
        .main-sidebar .nav-link.active { color: #fff !important; background: rgba(255,255,255,0.1) !important; }
        .main-sidebar .brand-link { background: var(--porang-dark) !important; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand-text { color: #fff !important; font-weight: 700 !important; }
        .sidebar-mini .main-sidebar .brand-text { display: none; }
        .nav-sidebar .nav-treeview > .nav-item > .nav-link { padding-left: 2.5rem !important; }

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
        }

        .content-wrapper { background: #f4f6f9; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: none; }
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
                    <i class="fas fa-seedling me-1"></i> Koperasi Tani Porang
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

                    <li class="nav-header text-uppercase" style="font-size:0.65rem; color:#6c7a9c; padding-top:10px;">Data Koperasi</li>

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
                        <a href="{{ route('anggota.index') }}" class="nav-link {{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Petani</p>
                            @php $pending = \App\Models\Anggota::where('status','pending')->count() @endphp
                            @if($pending > 0)
                                <span class="badge badge-warning right">{{ $pending }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-header text-uppercase" style="font-size:0.65rem; color:#6c7a9c; padding-top:10px;">Data Pertanian</li>

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

                    <li class="nav-header text-uppercase" style="font-size:0.65rem; color:#6c7a9c; padding-top:10px;">Sistem</li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}#peta" class="nav-link">
                            <i class="nav-icon fas fa-globe-asia"></i>
                            <p>Peta GIS</p>
                        </a>
                    </li>

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
        <strong>Sistem Informasi Koperasi Tani Porang</strong>
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
