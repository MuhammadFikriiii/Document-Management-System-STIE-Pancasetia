<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampah / Recycle Bin | Bank Data STIE Pancasetia</title>
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

        .content-area {
            flex-grow: 1;
            padding: 28px 32px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Trash Header Banner */
        .trash-banner {
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .trash-info h3 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .trash-info p {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        .btn-empty-trash {
            padding: 10px 18px;
            background: #FEF2F2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-empty-trash:hover {
            background: #dc2626;
            color: white;
        }

        /* Grid */
        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .doc-card {
            background: white;
            border-radius: 14px;
            border: 1px solid #E2E8F0;
            padding: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            position: relative;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
        }

        .doc-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        .doc-icon {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .doc-icon.folder {
            color: #BA1D2E;
        }

        .doc-icon.file {
            color: #3b82f6;
        }

        .doc-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            word-break: break-word;
            line-height: 1.3;
        }

        .doc-meta {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .card-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            width: 100%;
            justify-content: center;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
        }

        .btn-action.restore {
            background: #F0FDF4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .btn-action.restore:hover {
            background: #16a34a;
            color: white;
        }

        .btn-action.delete {
            background: #FEF2F2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-action.delete:hover {
            background: #dc2626;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="topbar-left">
                <h1>Sampah / Recycle Bin</h1>
                <p>File dan folder yang telah dihapus sementara</p>
            </div>
        </header>

        <main class="content-area">

            <!-- SweetAlert notification -->
            @if(session('success'))
                <script>
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', confirmButtonColor: '#BA1D2E', timer: 3000 });
                </script>
            @endif

            <!-- Trash Banner -->
            <div class="trash-banner">
                <div class="trash-info">
                    <h3><i class="fas fa-trash-alt" style="color:#BA1D2E;"></i> Tempat Sampah</h3>
                    <p>File atau folder di sini dapat dipulihkan kembali ke direktori asal atau dihapus secara permanen.
                    </p>
                </div>
                @if(!$trashedFolders->isEmpty() || !$trashedFiles->isEmpty())
                    <form method="POST" action="{{ route('documents.trash.empty') }}"
                        onsubmit="return confirmEmptyTrash(event, this)">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-empty-trash">
                            <i class="fas fa-broom"></i> Kosongkan Sampah
                        </button>
                    </form>
                @endif
            </div>

            @if($trashedFolders->isEmpty() && $trashedFiles->isEmpty())
                <div
                    style="padding:80px; text-align:center; color:#94a3b8; background:white; border-radius:16px; border:1px solid #E2E8F0;">
                    <i class="fas fa-trash-restore"
                        style="font-size:48px; margin-bottom:16px; color:#CBD5E1; display:block;"></i>
                    <h4 style="font-size:16px; color:#475569; font-weight:600;">Tempat Sampah Kosong</h4>
                    <p style="font-size:13px; color:#94a3b8; margin-top:4px;">Tidak ada file atau folder yang terhapus saat
                        ini.</p>
                </div>
            @else
                <div class="doc-grid">
                    <!-- Trashed Folders -->
                    @foreach($trashedFolders as $folder)
                        <div class="doc-card">
                            <div>
                                <div class="doc-icon folder"><i class="fas fa-folder"></i></div>
                                <div class="doc-name">{{ $folder->name }}</div>
                                <div class="doc-meta">Folder · Dihapus {{ $folder->deleted_at->diffForHumans() }}</div>
                            </div>
                            <div class="card-actions">
                                <form method="POST" action="{{ route('documents.trash.restoreFolder', $folder->id) }}">
                                    @csrf
                                    <button type="submit" class="btn-action restore" title="Pulihkan Folder">
                                        <i class="fas fa-undo"></i> Pulihkan
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('documents.trash.forceFolder', $folder->id) }}"
                                    onsubmit="return confirmForceDelete(event, this, '{{ addslashes($folder->name) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus Permanen">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <!-- Trashed Files -->
                    @foreach($trashedFiles as $file)
                        <div class="doc-card">
                            <div>
                                <div class="doc-icon file"><i class="fas fa-file-alt"></i></div>
                                <div class="doc-name">{{ $file->original_name }}</div>
                                <div class="doc-meta">{{ round($file->size / 1024, 1) }} KB · Dihapus
                                    {{ $file->deleted_at->diffForHumans() }}</div>
                            </div>
                            <div class="card-actions">
                                <form method="POST" action="{{ route('documents.trash.restoreFile', $file->id) }}">
                                    @csrf
                                    <button type="submit" class="btn-action restore" title="Pulihkan File">
                                        <i class="fas fa-undo"></i> Pulihkan
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('documents.trash.forceFile', $file->id) }}"
                                    onsubmit="return confirmForceDelete(event, this, '{{ addslashes($file->original_name) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus Permanen">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </main>
    </div>

    <script>
        function confirmForceDelete(event, form, name) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Permanen?',
                html: `Item <strong>${name}</strong> akan dihapus permanen dari server.<br><br>Tindakan ini <u>tidak dapat dibatalkan</u>!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
            return false;
        }

        function confirmEmptyTrash(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Kosongkan Seluruh Sampah?',
                html: 'Semua file dan folder di Tempat Sampah akan dihapus permanen dari server.<br><br>Tindakan ini <u>tidak dapat dibatalkan</u>!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Kosongkan!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
            return false;
        }
    </script>

</body>

</html>