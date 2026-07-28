<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Bank Data STIE Pancasetia</title>
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
            padding: 28px 32px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ── Stats Cards Grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
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

        .stat-icon.green {
            background: #F0FDF4;
            color: #16a34a;
        }

        .stat-icon.purple {
            background: #F5F3FF;
            color: #7c3aed;
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
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
        }

        .stat-info span {
            font-size: 11px;
            color: #64748b;
        }

        /* ── Dashboard Grid ── */
        .dash-grid {
            display: flex;
            flex-direction: column;
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
            font-size: 13px;
            font-weight: 600;
            color: #BA1D2E;
            text-decoration: none;
        }

        .card-header a:hover {
            text-decoration: underline;
        }

        /* Log List */
        .log-list {
            display: flex;
            flex-direction: column;
        }

        .log-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 24px;
            border-bottom: 1px solid #F8FAFC;
            transition: background 0.15s;
        }

        .log-item:last-child {
            border-bottom: none;
        }

        .log-item:hover {
            background: #FAFAFA;
        }

        .log-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .log-icon.upload {
            background: #EFF6FF;
            color: #2563eb;
        }

        .log-icon.delete {
            background: #FEF2F2;
            color: #dc2626;
        }

        .log-icon.create {
            background: #F0FDF4;
            color: #16a34a;
        }

        .log-icon.rename {
            background: #FFF7ED;
            color: #ea580c;
        }

        .log-icon.move {
            background: #F5F3FF;
            color: #7c3aed;
        }

        .log-icon.auth {
            background: #F1F5F9;
            color: #475569;
        }

        .log-content {
            flex-grow: 1;
        }

        .log-content strong {
            font-size: 13px;
            color: #1e293b;
            font-weight: 600;
        }

        .log-content p {
            font-size: 13px;
            color: #475569;
            margin-top: 2px;
        }

        .log-time {
            font-size: 11px;
            color: #94a3b8;
            white-space: nowrap;
        }

        /* Quick Action Buttons */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px 24px;
        }

        .quick-btn {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 12px;
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            border: 1px solid #E2E8F0;
            transition: all 0.2s;
            background: #F8FAFC;
        }

        .quick-btn:hover {
            border-color: #BA1D2E;
            background: white;
            transform: translateX(3px);
            box-shadow: 0 4px 12px rgba(186, 29, 46, 0.08);
            color: #BA1D2E;
        }

        .quick-btn i {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            color: #BA1D2E;
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
                <h1>Dashboard Administrator</h1>
                <p>Ringkasan sistem dan aktivitas terbaru Bank Data STIE Pancasetia</p>
            </div>
            <div class="topbar-right">
                <div class="avatar" title="{{ Auth::user()->name }}">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="content-area">

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon red"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <p>Total User</p>
                        <h2>{{ $totalUsers }}</h2>
                        <span>{{ $activeUsers }} user aktif</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green"><i class="fas fa-folder-open"></i></div>
                    <div class="stat-info">
                        <p>Total Folder</p>
                        <h2>{{ $totalFolders }}</h2>
                        <span>di seluruh sistem</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple"><i class="fas fa-file-alt"></i></div>
                    <div class="stat-info">
                        <p>Total File</p>
                        <h2>{{ $totalFiles }}</h2>
                        <span>tersimpan aman</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fas fa-hdd"></i></div>
                    <div class="stat-info">
                        <p>Storage Terpakai</p>
                        <h2>{{ $totalStorage >= 1048576 ? round($totalStorage / 1048576, 1) : round($totalStorage / 1024, 1) }}
                        </h2>
                        <span>{{ $totalStorage >= 1048576 ? 'MB' : 'KB' }} total kapasitas</span>
                    </div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dash-grid">
                <!-- 5 Latest Activity Logs -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-bolt" style="color:#BA1D2E;"></i> 5 Aktivitas Terbaru</h3>
                        <a href="{{ route('admin.logs') }}">Lihat Semua Audit Log &rarr;</a>
                    </div>
                    <div class="log-list">
                        @forelse($recentLogs as $log)
                            @php
                                $iconClass = 'auth';
                                $faIcon = 'fa-info-circle';
                                if (str_contains($log->action, 'upload')) {
                                    $iconClass = 'upload';
                                    $faIcon = 'fa-upload';
                                } elseif (str_contains($log->action, 'delete')) {
                                    $iconClass = 'delete';
                                    $faIcon = 'fa-trash';
                                } elseif (str_contains($log->action, 'create')) {
                                    $iconClass = 'create';
                                    $faIcon = 'fa-folder-plus';
                                } elseif (str_contains($log->action, 'rename')) {
                                    $iconClass = 'rename';
                                    $faIcon = 'fa-edit';
                                } elseif (str_contains($log->action, 'move')) {
                                    $iconClass = 'move';
                                    $faIcon = 'fa-arrows-alt';
                                } elseif (in_array($log->action, ['login', 'logout'])) {
                                    $iconClass = 'auth';
                                    $faIcon = $log->action === 'login' ? 'fa-sign-in-alt' : 'fa-sign-out-alt';
                                }
                            @endphp
                            <div class="log-item">
                                <div class="log-icon {{ $iconClass }}"><i class="fas {{ $faIcon }}"></i></div>
                                <div class="log-content">
                                    <strong>{{ $log->user->name ?? 'System' }}</strong>
                                    <p>{{ $log->description }}</p>
                                </div>
                                <div class="log-time" title="{{ $log->created_at }}">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <div style="padding:40px; text-align:center; color:#94a3b8;">
                                <i class="fas fa-history" style="font-size:32px; margin-bottom:10px; display:block;"></i>
                                Belum ada riwayat aktivitas tercatat.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>


        </main>
    </div>

</body>

</html>