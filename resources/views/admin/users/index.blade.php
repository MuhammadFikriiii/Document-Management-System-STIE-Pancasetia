<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – Manajemen User | Bank Data STIE Pancasetia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background: #F1F4F9;
            color: #1e293b;
            overflow: hidden;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            background: linear-gradient(160deg, #0f172a 0%, #1e293b 100%);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 0;
            flex-shrink: 0;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #BA1D2E, #e11d48);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            line-height: 1.2;
        }

        .sidebar-brand-text span {
            display: block;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .sidebar-brand-text strong {
            font-size: 14px;
            font-weight: 700;
            color: white;
        }

        .nav-section-label {
            padding: 20px 24px 8px;
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 0 12px;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.07);
            color: white;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #BA1D2E22, #BA1D2E33);
            color: white;
            border: 1px solid rgba(186, 29, 46, 0.3);
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar-footer {
            padding: 12px 12px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(186, 29, 46, 0.2);
            color: #f87171;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            border: 1px solid rgba(186, 29, 46, 0.3);
            margin: 16px 12px 12px;
        }

        /* ── Main ── */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            height: 68px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            border-bottom: 1px solid #E2E8F0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .topbar-left h1 {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .topbar-left p {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 1px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-form {
            position: relative;
            width: 260px;
        }

        .search-form i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search-form input {
            width: 100%;
            padding: 9px 36px 9px 35px;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            background: #F8FAFC;
        }

        .search-form input:focus {
            border-color: #BA1D2E;
            background: white;
            box-shadow: 0 0 0 3px rgba(186, 29, 46, 0.08);
        }

        .search-clear {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 13px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #BA1D2E, #e11d48);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        /* ── Content ── */
        .content-area {
            flex-grow: 1;
            padding: 28px 32px 60px 32px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ── Stats Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-icon.red {
            background: #FEF2F2;
            color: #BA1D2E;
        }

        .stat-icon.green {
            background: #F0FDF4;
            color: #16a34a;
        }

        .stat-icon.blue {
            background: #EFF6FF;
            color: #2563eb;
        }

        .stat-info p {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .stat-info h2 {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .stat-info span {
            font-size: 12px;
            color: #64748b;
        }

        /* ── Table Card ── */
        .table-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            flex-shrink: 0;
        }

        .table-card-header {
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #F1F5F9;
        }

        .table-card-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        .table-card-header p {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .btn-add-user {
            padding: 10px 18px;
            background: #BA1D2E;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }

        .btn-add-user:hover {
            background: #9e1826;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #F8FAFC;
            padding: 12px 24px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #E2E8F0;
        }

        tbody td {
            padding: 16px 24px;
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #FAFAFA;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-info strong {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .user-info span {
            font-size: 12px;
            color: #94a3b8;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-active {
            background: #F0FDF4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .badge-inactive {
            background: #FEF2F2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge-admin {
            background: #FFF7ED;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }

        .badge-divisi {
            background: #EFF6FF;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }

        /* Storage bar */
        .storage-bar {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .storage-bar-track {
            flex-grow: 1;
            height: 6px;
            background: #F1F5F9;
            border-radius: 99px;
            overflow: hidden;
        }

        .storage-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #BA1D2E, #e11d48);
            border-radius: 99px;
            transition: width 0.5s ease;
        }

        .storage-text {
            font-size: 12px;
            color: #64748b;
            white-space: nowrap;
            min-width: 70px;
            text-align: right;
        }

        /* Action buttons */
        .action-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: all 0.2s;
        }

        .btn-icon.edit {
            background: #EFF6FF;
            color: #2563eb;
        }

        .btn-icon.toggle-on {
            background: #ECFDF5;
            color: #16a34a;
        }

        .btn-icon.toggle-off {
            background: #FEF3C7;
            color: #d97706;
        }

        .btn-icon.delete {
            background: #FEF2F2;
            color: #dc2626;
        }

        .btn-icon:hover {
            filter: brightness(0.9);
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.5);
            display: none;
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-card {
            background: white;
            width: 450px;
            max-width: 90%;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: modalSlide 0.25s ease forwards;
        }

        @keyframes modalSlide {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 20px 24px;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }

        .modal-close {
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border 0.2s;
        }

        .form-control:focus {
            border-color: #BA1D2E;
            box-shadow: 0 0 0 3px rgba(186, 29, 46, 0.08);
        }

        .modal-footer {
            padding: 16px 24px;
            background: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-cancel {
            padding: 9px 16px;
            background: #E2E8F0;
            color: #475569;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-save {
            padding: 9px 20px;
            background: #BA1D2E;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-save:hover {
            background: #9e1826;
        }

        /* ── Modern Clean Pagination Styling ── */
        .pagination-wrapper {
            padding: 18px 24px;
            border-top: 1px solid #E2E8F0;
            background: #FAFAFA;
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .pagination-wrapper nav {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
        }

        .pagination-wrapper nav p {
            font-size: 13px !important;
            color: #64748b !important;
            margin: 0 !important;
            font-weight: 500 !important;
            line-height: 1.5 !important;
        }

        .pagination-wrapper nav p .font-medium,
        .pagination-wrapper nav p strong {
            color: #0f172a !important;
            font-weight: 700 !important;
        }

        .pagination-wrapper nav > div {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .pagination-wrapper nav span.relative,
        .pagination-wrapper nav ul {
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            border-radius: 10px !important;
            box-shadow: none !important;
            border: none !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .pagination-wrapper nav a,
        .pagination-wrapper nav span[aria-current="page"],
        .pagination-wrapper nav span[aria-disabled="true"] {
            padding: 0 12px !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.2s !important;
            border: 1px solid #E2E8F0 !important;
            color: #475569 !important;
            background: white !important;
            min-width: 36px !important;
            height: 36px !important;
            line-height: 34px !important;
            margin: 0 !important;
            box-sizing: border-box !important;
        }

        .pagination-wrapper nav span[aria-current="page"] span,
        .pagination-wrapper nav a span,
        .pagination-wrapper nav span[aria-disabled="true"] span {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: transparent !important;
            color: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            display: inline !important;
        }

        .pagination-wrapper nav a:hover {
            background: #BA1D2E !important;
            color: white !important;
            border-color: #BA1D2E !important;
            box-shadow: 0 2px 8px rgba(186, 29, 46, 0.25) !important;
        }

        .pagination-wrapper nav span[aria-current="page"] {
            background: #BA1D2E !important;
            color: white !important;
            border-color: #BA1D2E !important;
            font-weight: 700 !important;
        }

        .pagination-wrapper nav span[aria-disabled="true"] {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
            background: #F1F5F9 !important;
            color: #94a3b8 !important;
        }

        .pagination-wrapper nav svg {
            width: 14px !important;
            height: 14px !important;
            fill: currentColor !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <h1>Manajemen User</h1>
                <p>Kelola dan manipulasi semua akun pengguna Bank Data STIE Pancasetia</p>
            </div>
            <div class="topbar-right">
                <form method="GET" action="{{ route('admin.users') }}" class="search-form" id="search-form">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" id="search-input" placeholder="Cari nama atau email..."
                        value="{{ $search ?? '' }}" autocomplete="off">
                    @if($search)
                        <button type="button" class="search-clear" onclick="clearSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </form>
                <div class="avatar" title="{{ Auth::user()->name }}">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">

            <!-- SweetAlert notifications -->
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}',
                        confirmButtonColor: '#BA1D2E', timer: 3000, timerProgressBar: true
                    });
                </script>
            @endif
            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error', title: 'Gagal!', text: '{{ session('error') }}',
                        confirmButtonColor: '#BA1D2E'
                    });
                </script>
            @endif

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <p>Total Pengguna</p>
                        <h2>{{ $totalUsers }}</h2>
                        <span>terdaftar di sistem</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
                    <div class="stat-info">
                        <p>Pengguna Aktif</p>
                        <h2>{{ $activeUsers }}</h2>
                        <span>dari {{ $totalUsers }} pengguna</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-hdd"></i></div>
                    <div class="stat-info">
                        <p>Total Storage Terpakai</p>
                        <h2>{{ $totalStorage >= 1048576 ? round($totalStorage / 1048576, 1) : round($totalStorage / 1024, 1) }}
                        </h2>
                        <span>{{ $totalStorage >= 1048576 ? 'MB' : 'KB' }} dari semua divisi</span>
                    </div>
                </div>
            </div>

            <!-- User Table Card -->
            <div class="table-card">
                <div class="table-card-header" style="flex-wrap: wrap; gap: 16px;">
                    <div>
                        <h3>Daftar Pengguna</h3>
                        <p style="font-size:12px; color:#94a3b8; margin-top:2px;">
                            @if(!$users->isEmpty())
                                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }}
                                pengguna
                            @else
                                0 pengguna
                            @endif
                        </p>
                    </div>

                    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.users') }}"
                            style="display:flex; align-items:center; gap:8px;">
                            <input type="text" name="search" placeholder="Cari nama / email..."
                                value="{{ $search ?? '' }}"
                                style="padding:8px 12px; border:1px solid #E2E8F0; border-radius:8px; font-size:13px; outline:none; background:#F8FAFC; width:180px;">
                            <select name="per_page" onchange="this.form.submit()"
                                style="padding:8px 12px; border:1px solid #E2E8F0; border-radius:8px; font-size:13px; outline:none; background:#F8FAFC; cursor:pointer;">
                                <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10 / hal</option>
                                <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25 / hal</option>
                                <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50 / hal</option>
                                <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100 / hal</option>
                            </select>
                            <button type="submit"
                                style="padding:8px 14px; background:#BA1D2E; color:white; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                <i class="fas fa-search"></i>
                            </button>
                            @if($search || ($perPage ?? 10) != 10)
                                <a href="{{ route('admin.users') }}"
                                    style="font-size:12px; color:#64748b; text-decoration:none;">Reset</a>
                            @endif
                        </form>

                        <button class="btn-add-user" onclick="openCreateUserModal()">
                            <i class="fas fa-user-plus"></i> Tambah User Baru
                        </button>
                    </div>
                </div>

                @if($users->isEmpty())
                    <div style="padding:60px; text-align:center; color:#94a3b8;">
                        <i class="fas fa-users-slash"
                            style="font-size:40px; margin-bottom:12px; display:block; color:#CBD5E1;"></i>
                        <p>{{ $search ? 'Tidak ada pengguna yang cocok dengan pencarian.' : 'Belum ada pengguna terdaftar.' }}
                        </p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Divisi</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Storage Terpakai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                @php
                                    $storageBytes = $user->files_sum_size ?? 0;
                                    $storageMB = round($storageBytes / 1048576, 2);
                                    $storageKB = round($storageBytes / 1024, 1);
                                    $storageLabel = $storageBytes >= 1048576 ? $storageMB . ' MB' : $storageKB . ' KB';
                                    $pct = $totalStorage > 0 ? min(100, round(($storageBytes / $totalStorage) * 100)) : 0;
                                    $initials = strtoupper(substr($user->name, 0, 2));
                                    $colors = ['#667eea', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'];
                                    $avatarColor = $colors[$user->id % count($colors)];
                                @endphp
                                <tr>
                                    <!-- User info -->
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar"
                                                style="background: linear-gradient(135deg, {{ $avatarColor }}, {{ $avatarColor }}cc);">
                                                {{ $initials }}
                                            </div>
                                            <div class="user-info">
                                                <strong>{{ $user->name }}</strong>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Division -->
                                    <td style="font-size:13px; color:#475569; font-weight:500;">
                                        {{ $user->division->name ?? '—' }}
                                    </td>

                                    <!-- Role badge -->
                                    <td>
                                        <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-divisi' }}">
                                            <i class="fas fa-{{ $user->role === 'admin' ? 'crown' : 'user' }}"
                                                style="font-size:10px;"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <!-- Status badge -->
                                    <td>
                                        <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}">
                                            <i class="fas fa-circle" style="font-size:7px;"></i>
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    <!-- Storage bar -->
                                    <td style="min-width:180px;">
                                        <div class="storage-bar">
                                            <div class="storage-bar-track">
                                                <div class="storage-bar-fill" style="width: {{ $pct }}%;"></div>
                                            </div>
                                            <span class="storage-text">{{ $storageLabel }}</span>
                                        </div>
                                        <div style="font-size:11px; color:#94a3b8; margin-top:4px;">
                                            {{ $user->files_count }} file · {{ $pct }}% dari total
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="action-group">
                                            <!-- Edit User Button -->
                                            <button type="button" class="btn-icon edit" title="Edit User"
                                                onclick="openEditUserModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}', '{{ $user->division_id }}', {{ $user->is_active ? 'true' : 'false' }})">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            @if($user->role !== 'admin')
                                                <!-- Toggle Active -->
                                                <form method="POST" action="{{ route('admin.users.toggleActive', $user->id) }}"
                                                    style="margin:0;">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="btn-icon {{ $user->is_active ? 'toggle-on' : 'toggle-off' }}"
                                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun"
                                                        onclick="return confirm('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ addslashes($user->name) }}?')">
                                                        <i class="fas fa-{{ $user->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                                    </button>
                                                </form>

                                                <!-- Delete -->
                                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                                    style="margin:0;"
                                                    onsubmit="return confirmDeleteUser(event, this, '{{ addslashes($user->name) }}')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-icon delete" title="Hapus user">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($users->hasPages())
                        <div class="pagination-wrapper">
                            {{ $users->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </main>
    </div>

    <!-- ── Modal Create User ── -->
    <div class="modal-overlay" id="modalCreateUser">
        <div class="modal-card">
            <div class="modal-header">
                <h3><i class="fas fa-user-plus" style="color:#BA1D2E; margin-right:8px;"></i> Tambah User Baru</h3>
                <button class="modal-close" onclick="closeCreateUserModal()"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="cth. Ahmad Subagja" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Email</label>
                        <input type="email" name="email" class="form-control"
                            placeholder="cth. ahmad@stiepancasetia.ac.id" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter"
                            required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Role / Akses</label>
                        <select name="role" class="form-control" required>
                            <option value="divisi">Divisi (Pengguna Biasa)</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Divisi</label>
                        <select name="division_id" class="form-control">
                            <option value="">-- Pilih Divisi (Optional untuk Admin) --</option>
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeCreateUserModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ── Modal Edit User ── -->
    <div class="modal-overlay" id="modalEditUser">
        <div class="modal-card">
            <div class="modal-header">
                <h3><i class="fas fa-user-edit" style="color:#BA1D2E; margin-right:8px;"></i> Edit Data User</h3>
                <button class="modal-close" onclick="closeEditUserModal()"><i class="fas fa-times"></i></button>
            </div>
            <form id="formEditUser" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password Baru <span
                                style="font-size:11px; color:#94a3b8; text-transform:none;">(Kosongkan jika tidak
                                diubah)</span></label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Masukkan password baru...">
                    </div>
                    <div class="form-group">
                        <label>Role / Akses</label>
                        <select name="role" id="edit_role" class="form-control" required>
                            <option value="divisi">Divisi (Pengguna Biasa)</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Divisi</label>
                        <select name="division_id" id="edit_division_id" class="form-control">
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisions as $div)
                                <option value="{{ $div->id }}">{{ $div->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeEditUserModal()">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function clearSearch() {
            document.getElementById('search-input').value = '';
            document.getElementById('search-form').submit();
        }

        document.getElementById('search-input').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') document.getElementById('search-form').submit();
        });

        function confirmDeleteUser(event, form, name) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Pengguna?',
                html: `Akun <strong>${name}</strong> akan dihapus permanen beserta semua datanya.<br><br>Tindakan ini <u>tidak dapat dibatalkan</u>!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
            return false;
        }

        // Modal Create User
        function openCreateUserModal() {
            document.getElementById('modalCreateUser').style.display = 'flex';
        }
        function closeCreateUserModal() {
            document.getElementById('modalCreateUser').style.display = 'none';
        }

        // Modal Edit User
        function openEditUserModal(id, name, email, role, divisionId, isActive) {
            document.getElementById('formEditUser').action = '/admin/users/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_division_id').value = divisionId || '';
            document.getElementById('modalEditUser').style.display = 'flex';
        }
        function closeEditUserModal() {
            document.getElementById('modalEditUser').style.display = 'none';
        }
    </script>
</body>

</html>