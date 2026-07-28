<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log Aktivitas | Admin STIE Pancasetia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

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
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #BA1D2E, #e11d48);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-size: 18px; flex-shrink: 0;
        }

        .sidebar-brand-text { line-height: 1.2; }
        .sidebar-brand-text span {
            display: block; font-size: 10px; color: rgba(255,255,255,0.4);
            text-transform: uppercase; letter-spacing: 1px; font-weight: 500;
        }
        .sidebar-brand-text strong { font-size: 14px; font-weight: 700; color: white; }

        .nav-section-label {
            padding: 20px 24px 8px; font-size: 10px; font-weight: 600;
            color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 1.5px;
        }

        .nav-menu { display: flex; flex-direction: column; gap: 2px; padding: 0 12px; flex-grow: 1; }

        .nav-item {
            display: flex; align-items: center; gap: 12px; padding: 11px 16px;
            color: rgba(255,255,255,0.6); text-decoration: none; font-size: 14px;
            font-weight: 500; border-radius: 10px; transition: all 0.2s;
        }

        .nav-item:hover { background: rgba(255,255,255,0.07); color: white; }

        .nav-item.active {
            background: linear-gradient(135deg, #BA1D2E22, #BA1D2E33);
            color: white; border: 1px solid rgba(186,29,46,0.3);
        }

        .nav-item i { width: 18px; text-align: center; font-size: 15px; }

        .sidebar-footer { padding: 12px 12px 20px; border-top: 1px solid rgba(255,255,255,0.08); }

        .admin-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(186,29,46,0.2); color: #f87171; font-size: 11px;
            font-weight: 600; padding: 4px 10px; border-radius: 20px;
            border: 1px solid rgba(186,29,46,0.3); margin: 16px 12px 12px;
        }

        /* ── Main ── */
        .main-wrapper { flex-grow: 1; display: flex; flex-direction: column; overflow: hidden; }

        .topbar {
            height: 68px; background: white; display: flex; align-items: center;
            justify-content: space-between; padding: 0 32px; border-bottom: 1px solid #E2E8F0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }

        .topbar-left h1 { font-size: 18px; font-weight: 700; color: #0f172a; }
        .topbar-left p  { font-size: 12px; color: #94a3b8; margin-top: 1px; }

        .avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #BA1D2E, #e11d48);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 14px;
        }

        /* ── Content ── */
        .content-area {
            flex-grow: 1; padding: 28px 32px 60px 32px; overflow-y: auto;
            display: flex; flex-direction: column; gap: 24px;
        }

        /* Filter Form Bar */
        .filter-bar {
            background: white; border-radius: 16px; padding: 18px 24px;
            border: 1px solid #E2E8F0; display: flex; align-items: center;
            justify-content: space-between; gap: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            flex-wrap: wrap;
        }

        .filter-inputs { display: flex; align-items: center; gap: 12px; flex-grow: 1; flex-wrap: wrap; }

        .search-box {
            position: relative; flex-grow: 1; min-width: 240px; max-width: 340px;
        }

        .search-box i {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 14px;
        }

        .search-box input {
            width: 100%; padding: 10px 14px 10px 36px; border: 1px solid #E2E8F0;
            border-radius: 10px; font-size: 14px; outline: none; background: #F8FAFC;
        }

        .search-box input:focus {
            border-color: #BA1D2E; background: white; box-shadow: 0 0 0 3px rgba(186,29,46,0.08);
        }

        .select-box select {
            padding: 10px 14px; border: 1px solid #E2E8F0; border-radius: 10px;
            font-size: 13px; outline: none; background: #F8FAFC; color: #1e293b;
            cursor: pointer; min-width: 160px;
        }

        .btn-filter {
            padding: 10px 18px; background: #BA1D2E; color: white; border: none;
            border-radius: 10px; font-weight: 600; font-size: 13px; cursor: pointer;
            transition: background 0.2s; display: inline-flex; align-items: center; gap: 6px;
        }

        .btn-filter:hover { background: #9e1826; }

        .btn-reset {
            padding: 10px 14px; background: #F1F5F9; color: #64748b; border: 1px solid #E2E8F0;
            border-radius: 10px; font-weight: 500; font-size: 13px; text-decoration: none;
        }

        /* ── Table Card ── */
        .table-card {
            background: white; border-radius: 16px; border: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03); overflow: hidden;
        }

        .table-card-header {
            padding: 18px 24px; display: flex; align-items: center;
            justify-content: space-between; border-bottom: 1px solid #F1F5F9;
        }

        .table-card-header h3 { font-size: 16px; font-weight: 700; color: #0f172a; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            background: #F8FAFC; padding: 12px 24px; text-align: left;
            font-size: 11px; font-weight: 600; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #E2E8F0;
        }

        tbody td {
            padding: 14px 24px; border-bottom: 1px solid #F1F5F9;
            vertical-align: middle; font-size: 13px;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #FAFAFA; }

        .user-info { display: flex; align-items: center; gap: 10px; }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 8px; background: #E2E8F0;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12px; color: #475569; flex-shrink: 0;
        }

        /* Action Badges */
        .action-badge {
            display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px;
            border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase;
        }

        .action-upload   { background: #EFF6FF; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .action-delete   { background: #FEF2F2; color: #dc2626; border: 1px solid #fecaca; }
        .action-create   { background: #F0FDF4; color: #15803d; border: 1px solid #bbf7d0; }
        .action-rename   { background: #FFF7ED; color: #c2410c; border: 1px solid #fed7aa; }
        .action-move     { background: #F5F3FF; color: #6d28d9; border: 1px solid #ddd6fe; }
        /* ── Modern Clean Pagination Styling ── */
        .pagination-wrapper {
            padding: 18px 24px; border-top: 1px solid #E2E8F0; background: #FAFAFA;
            border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;
        }

        .pagination-wrapper nav {
            display: flex !important; align-items: center !important; justify-content: space-between !important;
            width: 100% !important; flex-wrap: wrap !important; gap: 12px !important;
        }

        .pagination-wrapper nav p {
            font-size: 13px !important; color: #64748b !important; margin: 0 !important; font-weight: 500 !important; line-height: 1.5 !important;
        }

        .pagination-wrapper nav p .font-medium,
        .pagination-wrapper nav p strong {
            color: #0f172a !important; font-weight: 700 !important;
        }

        .pagination-wrapper nav > div {
            display: flex !important; align-items: center !important; gap: 6px !important;
        }

        .pagination-wrapper nav span.relative,
        .pagination-wrapper nav ul {
            display: inline-flex !important; align-items: center !important; gap: 4px !important; border-radius: 10px !important;
            box-shadow: none !important; border: none !important; list-style: none !important; margin: 0 !important; padding: 0 !important;
        }

        .pagination-wrapper nav a,
        .pagination-wrapper nav span[aria-current="page"],
        .pagination-wrapper nav span[aria-disabled="true"] {
            padding: 0 12px !important; border-radius: 8px !important; font-size: 13px !important; font-weight: 600 !important;
            text-decoration: none !important; display: inline-flex !important; align-items: center !important; justify-content: center !important;
            transition: all 0.2s !important; border: 1px solid #E2E8F0 !important; color: #475569 !important; background: white !important;
            min-width: 36px !important; height: 36px !important; line-height: 34px !important; margin: 0 !important; box-sizing: border-box !important;
        }

        .pagination-wrapper nav span[aria-current="page"] span,
        .pagination-wrapper nav a span,
        .pagination-wrapper nav span[aria-disabled="true"] span {
            padding: 0 !important; margin: 0 !important; border: none !important; background: transparent !important;
            color: inherit !important; font-size: inherit !important; font-weight: inherit !important; line-height: inherit !important; display: inline !important;
        }

        .pagination-wrapper nav a:hover {
            background: #BA1D2E !important; color: white !important; border-color: #BA1D2E !important;
            box-shadow: 0 2px 8px rgba(186,29,46,0.25) !important;
        }

        .pagination-wrapper nav span[aria-current="page"] {
            background: #BA1D2E !important; color: white !important; border-color: #BA1D2E !important; font-weight: 700 !important;
        }

        .pagination-wrapper nav span[aria-disabled="true"] {
            opacity: 0.4 !important; cursor: not-allowed !important; background: #F1F5F9 !important; color: #94a3b8 !important;
        }

        .pagination-wrapper nav svg {
            width: 14px !important; height: 14px !important; fill: currentColor !important; display: inline-block !important; vertical-align: middle !important;
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
                <h1>Audit Log Aktivitas</h1>
                <p>Catatan rekam jejak aktivitas pengguna di sistem</p>
            </div>
            <div class="topbar-right">
                <div class="avatar" title="{{ Auth::user()->name }}">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="content-area">

            <!-- Filter Bar -->
            <form method="GET" action="{{ route('admin.logs') }}" class="filter-bar">
                <div class="filter-inputs">
                    <!-- Search Input -->
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Cari deskripsi atau nama user..." value="{{ $search ?? '' }}">
                    </div>

                    <!-- Filter by Action -->
                    <div class="select-box">
                        <select name="action">
                            <option value="">-- Semua Jenis Aksi --</option>
                            @foreach($actionOptions as $actKey => $actLabel)
                                <option value="{{ $actKey }}" {{ ($action ?? '') == $actKey ? 'selected' : '' }}>
                                    {{ $actLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by User -->
                    <div class="select-box">
                        <select name="user_id">
                            <option value="">-- Semua Pengguna --</option>
                            @foreach($allUsers as $u)
                                <option value="{{ $u->id }}" {{ ($userId ?? '') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Per Page Select -->
                    <div class="select-box">
                        <select name="per_page" onchange="this.form.submit()" title="Tampilkan per halaman">
                            <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10 data / hal</option>
                            <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25 data / hal</option>
                            <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50 data / hal</option>
                            <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100 data / hal</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filter</button>
                    @if($search || $action || $userId || ($perPage ?? 10) != 10)
                        <a href="{{ route('admin.logs') }}" class="btn-reset">Reset Filter</a>
                    @endif
                </div>
            </form>

            <!-- Table Card -->
            <div class="table-card">
                <div class="table-card-header">
                    <h3><i class="fas fa-history" style="color:#BA1D2E;"></i> Rekam Jejak Sistem</h3>
                    <span style="font-size:12px; color:#94a3b8;">
                        @if(!$logs->isEmpty())
                            Menampilkan {{ $logs->firstItem() }} - {{ $logs->lastItem() }} dari {{ $logs->total() }} total log
                        @else
                            0 data
                        @endif
                    </span>
                </div>

                @if($logs->isEmpty())
                    <div style="padding:60px; text-align:center; color:#94a3b8;">
                        <i class="fas fa-search" style="font-size:40px; margin-bottom:12px; display:block; color:#CBD5E1;"></i>
                        <p>Tidak ada log aktivitas yang cocok dengan kriteria filter.</p>
                    </div>
                @else
                    <div class="table-responsive" style="overflow-x: auto; overflow-y: auto; max-height: calc(100vh - 300px);">
                        <table>
                            <thead style="position: sticky; top: 0; z-index: 10;">
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Jenis Aksi</th>
                                    <th>Keterangan Aktivitas</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    @php
                                        $badgeClass = 'action-auth';
                                        if (str_contains($log->action, 'upload')) $badgeClass = 'action-upload';
                                        elseif (str_contains($log->action, 'delete')) $badgeClass = 'action-delete';
                                        elseif (str_contains($log->action, 'create')) $badgeClass = 'action-create';
                                        elseif (str_contains($log->action, 'rename')) $badgeClass = 'action-rename';
                                        elseif (str_contains($log->action, 'move'))   $badgeClass = 'action-move';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong style="display:block; color:#1e293b;">{{ $log->user->name ?? 'System' }}</strong>
                                                    <span style="font-size:11px; color:#94a3b8;">{{ $log->user->email ?? '—' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="action-badge {{ $badgeClass }}">
                                                {{ str_replace('_', ' ', $log->action) }}
                                            </span>
                                        </td>
                                        <td style="color:#334155; font-weight:500;">
                                            {{ $log->description }}
                                        </td>
                                        <td>
                                            <div style="color:#1e293b; font-weight:500;">{{ $log->created_at->format('d M Y, H:i') }}</div>
                                            <div style="font-size:11px; color:#94a3b8;">{{ $log->created_at->diffForHumans() }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($logs->hasPages())
                        <div class="pagination-wrapper">
                            {{ $logs->links() }}
                        </div>
                    @endif
                @endif
            </div>


        </main>
    </div>

</body>

</html>
