<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Divisi | Bank Data STIE Pancasetia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background-color: #BA1D2E;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            flex-shrink: 0;
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 24px;
            margin-bottom: 40px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 0 16px;
            flex-grow: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-item.active {
            background-color: #9D1927;
        }

        .nav-item i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 0 16px;
            margin-top: auto;
        }

        /* Admin Sidebar Overrides */
        .sidebar.admin-sidebar {
            background: linear-gradient(160deg, #0f172a 0%, #1e293b 100%) !important;
            padding: 0 !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15) !important;
        }

        .sidebar.admin-sidebar .sidebar-brand {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 28px 24px 24px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            margin-bottom: 0 !important;
            font-size: 14px !important;
        }

        .sidebar.admin-sidebar .sidebar-brand-icon {
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

        .sidebar.admin-sidebar .admin-badge {
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

        .sidebar.admin-sidebar .nav-section-label {
            padding: 20px 24px 8px;
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .sidebar.admin-sidebar .nav-menu {
            padding: 0 12px !important;
            gap: 2px !important;
        }

        .sidebar.admin-sidebar .nav-item {
            padding: 11px 16px !important;
            font-size: 14px !important;
            border-radius: 10px !important;
            color: rgba(255, 255, 255, 0.6) !important;
            gap: 12px !important;
        }

        .sidebar.admin-sidebar .nav-item:hover {
            background: rgba(255, 255, 255, 0.07) !important;
            color: white !important;
        }

        .sidebar.admin-sidebar .nav-item.active {
            background: linear-gradient(135deg, #BA1D2E22, #BA1D2E33) !important;
            color: white !important;
            border: 1px solid rgba(186, 29, 46, 0.3) !important;
        }

        .sidebar.admin-sidebar .sidebar-footer {
            padding: 12px 12px 20px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            margin-top: auto;
        }

        /* Main Content */
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

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .content-area {
            flex-grow: 1;
            padding: 28px 32px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, #BA1D2E 0%, #881320 100%);
            color: white;
            border-radius: 20px;
            padding: 32px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            box-shadow: 0 8px 30px rgba(186, 29, 46, 0.25);
            position: relative;
            overflow: hidden;
            min-height: 150px;
            width: 100%;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: 140px;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            right: -40px;
            bottom: -50px;
            width: 240px;
            height: 240px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome-text {
            flex: 1;
            z-index: 1;
            min-width: 0;
        }

        .welcome-text h2 {
            font-size: 26px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            word-break: break-word;
        }

        .welcome-text p {
            font-size: 14px;
            opacity: 0.92;
            line-height: 1.6;
            font-weight: 400;
            max-width: 680px;
        }

        .badge-divisi {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.18);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 14px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .welcome-action {
            z-index: 1;
            flex-shrink: 0;
        }

        .btn-go-docs {
            padding: 14px 26px;
            background: white;
            color: #BA1D2E;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }

        .btn-go-docs:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
            background: #fff8f8;
        }

        @media (max-width: 768px) {
            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 24px 28px;
                gap: 20px;
            }

            .welcome-text h2 {
                font-size: 22px;
            }

            .btn-go-docs {
                width: 100%;
                justify-content: center;
            }
        }


        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-icon.red {
            background: #FEF2F2;
            color: #BA1D2E;
        }

        .stat-icon.blue {
            background: #EFF6FF;
            color: #2563eb;
        }

        .stat-icon.amber {
            background: #FFFBEB;
            color: #d97706;
        }

        .stat-icon.purple {
            background: #F5F3FF;
            color: #7c3aed;
        }

        .stat-info p {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .stat-info h3 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .stat-info span {
            font-size: 11px;
            color: #64748b;
        }

        .storage-bar-wrapper {
            width: 100%;
            margin-top: 6px;
        }

        .storage-bar-track {
            height: 6px;
            background: #E2E8F0;
            border-radius: 4px;
            overflow: hidden;
        }

        .storage-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #BA1D2E, #e11d48);
            border-radius: 4px;
        }

        /* Dashboard Dual Layout */
        .dash-grid {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 24px;
        }

        .card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #F1F5F9;
        }

        .card-header h3 {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-header a {
            font-size: 12px;
            color: #BA1D2E;
            font-weight: 600;
            text-decoration: none;
        }

        .card-header a:hover {
            text-decoration: underline;
        }

        /* Recent Files List */
        .file-list {
            display: flex;
            flex-direction: column;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            border-bottom: 1px solid #F8FAFC;
            transition: background 0.15s;
        }

        .file-item:last-child {
            border-bottom: none;
        }

        .file-item:hover {
            background: #F8FAFC;
        }

        .file-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #FEF2F2;
            color: #BA1D2E;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .file-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
        }

        .file-meta {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        .btn-view {
            padding: 6px 12px;
            background: #F1F5F9;
            color: #475569;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background: #BA1D2E;
            color: white;
        }

        /* Logs Timeline */
        .log-list {
            display: flex;
            flex-direction: column;
        }

        .log-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 24px;
            border-bottom: 1px solid #F8FAFC;
        }

        .log-item:last-child {
            border-bottom: none;
        }

        .log-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #BA1D2E;
            margin-top: 5px;
            flex-shrink: 0;
        }

        .log-content {
            flex-grow: 1;
        }

        .log-content strong {
            font-size: 12px;
            color: #0f172a;
            display: block;
        }

        .log-content p {
            font-size: 12px;
            color: #64748b;
            margin-top: 1px;
            line-height: 1.3;
        }

        .log-time {
            font-size: 10px;
            color: #94a3b8;
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">Dashboard Divisi</div>
            <div style="display:flex; align-items:center; gap:12px;">
                <span
                    style="font-size:13px; color:#64748b; font-weight:500;">{{ $user->division->name ?? 'Divisi' }}</span>
            </div>
        </header>

        <main class="content-area">

            <!-- Welcome Banner -->
            <div class="welcome-card">
                <div class="welcome-text">
                    <h2>Selamat Datang, {{ $user->name }}!</h2>
                    <p>Kelola dokumen, unduh arsip, dan pantau aktivitas penyimpanan divisi Anda di sini.</p>
                    <div class="badge-divisi">
                        <i class="fas fa-building"></i> {{ $user->division->name ?? 'Divisi Umum' }}
                    </div>
                </div>
                <div class="welcome-action">
                    <a href="{{ route('divisi.documents') }}" class="btn-go-docs">
                        <i class="fas fa-folder-open"></i> Buka Manajemen File &rarr;
                    </a>
                </div>

            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-file-alt"></i></div>
                    <div class="stat-info">
                        <p>Total File Divisi</p>
                        <h3>{{ $totalFiles }}</h3>
                        <span>file tersimpan</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-folder"></i></div>
                    <div class="stat-info">
                        <p>Total Folder</p>
                        <h3>{{ $totalFolders }}</h3>
                        <span>folder direktori</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon amber"><i class="fas fa-globe"></i></div>
                    <div class="stat-info">
                        <p>File Publik Shared</p>
                        <h3>{{ $publicFiles }}</h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-hdd"></i></div>
                    <div class="stat-info" style="width: 100%;">
                        <p>Kapasitas Storage</p>
                        <h3>{{ round($totalStorage / 1048576, 1) }} <span
                                style="font-size:13px; font-weight:600; color:#64748b;">MB</span></h3>
                        <span>{{ $storagePct }}% dari 50 GB</span>
                        <div class="storage-bar-wrapper">
                            <div class="storage-bar-track">
                                <div class="storage-bar-fill" style="width: {{ $storagePct }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dual Grid: Recent Files + Logs -->
            <div class="dash-grid">
                <!-- Recent Files Card -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-clock" style="color:#BA1D2E;"></i> 5 File Terbaru Upload</h3>
                        <a href="{{ route('divisi.documents') }}">Lihat Semua File &rarr;</a>
                    </div>
                    <div class="file-list">
                        @forelse($recentFiles as $file)
                            <div class="file-item">
                                <div class="file-left">
                                    <div class="file-icon">
                                        <i
                                            class="fas {{ in_array(strtolower($file->extension), ['pdf']) ? 'fa-file-pdf' : (in_array(strtolower($file->extension), ['doc', 'docx']) ? 'fa-file-word' : (in_array(strtolower($file->extension), ['xls', 'xlsx']) ? 'fa-file-excel' : 'fa-file-alt')) }}"></i>
                                    </div>
                                    <div>
                                        <div class="file-name">{{ $file->original_name }}</div>
                                        <div class="file-meta">
                                            {{ round($file->size / 1024, 1) }} KB · Unggah oleh
                                            {{ $file->creator->name ?? 'User' }} · {{ $file->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('divisi.documents.downloadFile', $file->id) }}" class="btn-view">
                                        <i class="fas fa-download"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div style="padding:40px; text-align:center; color:#94a3b8;">
                                <i class="fas fa-cloud-upload-alt"
                                    style="font-size:36px; margin-bottom:8px; display:block; color:#CBD5E1;"></i>
                                Belum ada file yang diunggah di divisi ini.
                            </div>
                        @endforelse

                    </div>
                </div>

                <!-- Recent Activity Logs Card -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-history" style="color:#BA1D2E;"></i> Aktivitas Divisi</h3>
                    </div>
                    <div class="log-list">
                        @forelse($recentLogs as $log)
                            <div class="log-item">
                                <div class="log-dot"></div>
                                <div class="log-content">
                                    <strong>{{ $log->user->name ?? 'User' }}</strong>
                                    <p>{{ $log->description }}</p>
                                </div>
                                <div class="log-time">{{ $log->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div style="padding:40px; text-align:center; color:#94a3b8;">
                                <i class="fas fa-history"
                                    style="font-size:32px; margin-bottom:8px; display:block; color:#CBD5E1;"></i>
                                Belum ada riwayat aktivitas.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>

</html>