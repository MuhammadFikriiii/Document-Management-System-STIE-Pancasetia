<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System - STIE Pancasetia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Base resets */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #F8F9FA;
            color: #333;
            overflow: hidden;
        }

        /* Sidebar */
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

        /* Main Content */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top Header */
        .topbar {
            height: 70px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid #EAEAEA;
        }

        .page-title {
            font-size: 22px;
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            position: relative;
            width: 250px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 35px;
            border: 1px solid #EAEAEA;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        .btn-notification {
            background: none;
            border: none;
            color: #666;
            font-size: 20px;
            cursor: pointer;
        }

        /* Content Area */
        .content-area {
            flex-grow: 1;
            padding: 25px 30px;
            overflow-y: auto;
            display: flex;
            gap: 25px;
        }

        /* Left Side (Documents Grid) */
        .documents-section {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Header Card inside Documents Section */
        .doc-header-card {
            background: white;
            border-radius: 15px;
            /* Softer radius */
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #EAEAEA;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .doc-header-left p {
            color: #000000ff;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .doc-header-left h3 {
            color: #BA1D2E;
            font-size: 22px;
            font-weight: 600;
        }

        .doc-header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-btn {
            background: white;
            color: #333;
            border: 1px solid #000000ff;
            padding: 8px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            background: #ac1234;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            color: white;
        }

        .action-btn.primary {
            background: #BA1D2E;
            color: white;
            border: none;
        }

        .action-btn.primary:hover {
            background: #9D1927;
            box-shadow: 0 4px 12px rgba(186, 29, 46, 0.2);
            color: white;
        }

        /* Grid */
        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 10px;
            justify-items: center;
        }

        /* Cute Hover Animations */
        /* Transparent Icon Layout (No Boxes) */
        .doc-card {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 16px;
            padding: 10px 5px;
            width: 145px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }

        .doc-card:hover {
            background: rgba(186, 29, 46, 0.04);
            transform: translateY(-2px);
        }

        .doc-card.selected {
            background: rgba(186, 29, 46, 0.08);
            border-color: rgba(186, 29, 46, 0.2);
            box-shadow: 0 4px 15px rgba(186, 29, 46, 0.1);
            transform: translateY(-2px);
        }

        .doc-card-title {
            font-size: 13px;
            color: #333;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }

        .doc-icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
            margin-bottom: 8px;
            background: #ffffff;
            border-radius: 20px;
            width: 130px;
            height: 130px;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 2px solid #222222;
            /* Black Outline */
        }

        .doc-icon-wrapper:hover {
            transform: scale(1.05);
        }

        .custom-folder-icon {
            width: 95px;
            height: 95px;
            cursor: pointer;
        }

        .doc-icon-svg {
            width: 85px;
            height: 95px;
            cursor: pointer;
        }

        .doc-card-footer {
            display: none;
        }

        /* 3-Dot Menu Dropdown */
        .card-actions-menu {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 10;
        }

        .menu-dots-btn {
            background: transparent;
            border: none;
            color: #444;
            font-size: 18px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.2s, background 0.2s;
        }

        .menu-dots-btn:hover {
            background: rgba(0, 0, 0, 0.08);
            color: #000;
        }

        .doc-icon-wrapper:hover .menu-dots-btn {
            opacity: 1;
        }

        .menu-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            flex-direction: column;
            min-width: 120px;
            padding: 5px 0;
            border: 1px solid #eee;
        }

        .card-actions-menu:hover .menu-dropdown {
            display: flex;
        }

        .dropdown-item {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background: #f5f5f5;
        }

        .dropdown-item.edit {
            color: #3b82f6;
        }

        .dropdown-item.delete {
            color: #ef4444;
        }

        .menu-dropdown form {
            margin: 0;
        }

        .preview-sidebar {
            width: 320px;
            background: #ffffff;
            border-left: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow-y: auto;
            padding: 30px;
        }

        .preview-title {
            color: #BA1D2E;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .preview-filename {
            font-size: 20px;
            font-weight: 600;
            color: #111;
            margin-bottom: 35px;
            line-height: 1.4;
            word-break: break-word;
        }

        .meta-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .meta-label {
            font-size: 12px;
            font-weight: 500;
            color: #888;
        }

        .meta-value {
            font-size: 14px;
            font-weight: 500;
            color: #222;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 16px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: modalSlideIn 0.3s ease forwards;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(30px) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .modal-content h3 {
            margin-bottom: 20px;
            color: #111;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #EAEAEA;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.2s;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #BA1D2E;
            box-shadow: 0 0 0 3px rgba(186, 29, 46, 0.1);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-cloud"></i> STIE Pancasetia
        </div>
        <div class="nav-menu">
            <a href="#" class="nav-item">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('divisi.documents') }}" class="nav-item active">
                <i class="fas fa-file-alt"></i> Document
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-tags"></i> All Tags
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-folder"></i> Archives
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-envelope"></i> E-mail
            </a>
        </div>
        <div class="sidebar-footer">
            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="page-title">Document Management System</div>
            <div class="topbar-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <button class="btn-notification">
                    <i class="far fa-bell"></i>
                </button>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <!-- Documents Section (Left) -->
            <div class="documents-section">

                <!-- SweetAlert2 Trigger for Success/Error Messages -->
                @if(session('success'))
                    <script>
                        Swal.fire({
                            title: 'Yay!',
                            text: '{{ session('success') }}',
                            icon: 'success',
                            confirmButtonColor: '#BA1D2E',
                            confirmButtonText: 'Great!'
                        });
                    </script>
                @endif

                @if($errors->any())
                    <script>
                        Swal.fire({
                            title: 'Oops!',
                            text: '{{ $errors->first() }}',
                            icon: 'error',
                            confirmButtonColor: '#BA1D2E',
                            confirmButtonText: 'Got it'
                        });
                    </script>
                @endif

                <div class="doc-header-card">
                    <div class="doc-header-left">
                        <p>All Documents</p>
                        <h3>
                            @if($currentFolder)
                                <a href="{{ route('divisi.documents', ['folder_id' => $currentFolder->parent_id]) }}"
                                    style="color: #BA1D2E; text-decoration: none; margin-right: 5px;">
                                    <i class="fas fa-arrow-left"></i>
                                </a>
                                {{ $currentFolder->name }}
                            @else
                                Root Directory
                            @endif
                        </h3>
                    </div>
                    <div class="action-buttons" style="display: flex; align-items: center; gap: 10px;">
                        <button class="action-btn"
                            onclick="document.getElementById('modal-folder').style.display='flex'">
                            <i class="fas fa-folder-plus"></i> New Folder
                        </button>
                        <button class="action-btn"
                            onclick="document.getElementById('modal-upload-folder').style.display='flex'">
                            <i class="fas fa-folder-open"></i> Upload Folder
                        </button>
                        <button class="action-btn primary"
                            onclick="document.getElementById('modal-file').style.display='flex'">
                            <i class="fas fa-cloud-upload-alt"></i> Upload File
                        </button>

                        <!-- Global 3-Dot Menu for Selected Item -->
                        <div class="global-actions-menu" id="global-actions-menu"
                            style="position: relative; margin-left: 5px;">
                            <button id="global-menu-btn" onclick="toggleGlobalMenu()" disabled
                                style="background: transparent; border: none; color: #444; font-size: 20px; cursor: not-allowed; opacity: 0.4; padding: 5px 12px; border-radius: 5px; transition: all 0.2s;">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div id="global-menu-dropdown"
                                style="display: none; position: absolute; top: 100%; right: 0; background: #ffffff; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15); border-radius: 8px; flex-direction: column; min-width: 120px; padding: 5px 0; border: 1px solid #eee; z-index: 50;">
                                <button id="global-edit-btn"
                                    style="background: none; border: none; width: 100%; text-align: left; padding: 8px 15px; cursor: pointer; font-size: 14px; color: #3b82f6; display: flex; align-items: center; gap: 10px;"><i
                                        class="fas fa-pen"></i> Edit</button>
                                <form id="global-delete-form" method="POST" style="margin: 0;"
                                    onsubmit="return confirmDelete(event, this, 'item');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; width: 100%; text-align: left; padding: 8px 15px; cursor: pointer; font-size: 14px; color: #ef4444; display: flex; align-items: center; gap: 10px;"><i
                                            class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="doc-grid">
                    <!-- Dynamic Folders -->
                    @foreach($folders as $folder)
                        <div class="doc-card" id="card-folder-{{ $folder->id }}">
                            <div style="display:flex; flex-direction:column; align-items:center; width:100%;">
                                @php
                                    $folderColor = $folder->visibility == 'public' ? '#FBBF24' : '#BA1D2E';
                                    $canEdit = ($folder->division_id == Auth::user()->division_id && $folder->created_by == Auth::id()) ? 'true' : 'false';
                                @endphp
                                <div class="doc-icon-wrapper" style="color: {{ $folderColor }};">
                                    <div ondblclick="window.location.href='{{ route('divisi.documents', ['folder_id' => $folder->id]) }}'"
                                        onclick="showPreview('{{ $folder->id }}', '{{ $folder->name }}', '{{ $folder->creator->name ?? 'System' }}', '{{ $folder->division->name ?? '-' }}', '{{ $folder->created_at->format('d/m/y') }}', 'Folder', '-', '{{ $folder->visibility }}', {{ $canEdit }})"
                                        style="display:flex; justify-content:center; align-items:center; cursor:pointer;">
                                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
                                            class="custom-folder-icon">
                                            <!-- Paper inside -->
                                            <rect x="20" y="25" width="60" height="40" rx="3" fill="#ffffff"
                                                stroke="#e0e0e0" stroke-width="2" />
                                            <!-- Back flap -->
                                            <path
                                                d="M10,25 h25 l10,10 h45 a5,5 0 0 1 5,5 v40 a5,5 0 0 1 -5,5 h-80 a5,5 0 0 1 -5,-5 v-50 a5,5 0 0 1 5,-5 Z"
                                                fill="currentColor" opacity="0.8" />
                                            <!-- Front flap -->
                                            <path d="M5,45 h90 l-5,40 h-80 Z" fill="currentColor" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="doc-card-title" title="{{ $folder->name }}"
                                    ondblclick="window.location.href='{{ route('divisi.documents', ['folder_id' => $folder->id]) }}'"
                                    onclick="showPreview('{{ $folder->id }}', '{{ $folder->name }}', '{{ $folder->creator->name ?? 'System' }}', '{{ $folder->division->name ?? '-' }}', '{{ $folder->created_at->format('d/m/y') }}', 'Folder', '-', '{{ $folder->visibility }}', {{ $canEdit }})"
                                    style="cursor:pointer;">
                                    {{ $folder->name }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Dynamic Files -->
                    @foreach($files as $file)
                        <div class="doc-card" id="card-file-{{ $file->id }}">
                            @php
                                $canEdit = ($file->division_id == Auth::user()->division_id && $file->created_by == Auth::id()) ? 'true' : 'false';
                            @endphp
                            <div style="width:100%; display:flex; flex-direction:column; align-items:center;">
                                <div class="doc-icon-wrapper">
                                    <div onclick="showPreview('{{ $file->id }}', '{{ $file->original_name }}', '{{ $file->creator->name ?? 'System' }}', '{{ $file->division->name ?? '-' }}', '{{ $file->created_at->format('d/m/y') }}', '{{ $file->extension }}', '{{ round($file->size / 1024, 2) }} KB', '{{ $file->visibility }}', {{ $canEdit }})"
                                        style="display:flex; justify-content:center; align-items:center;">
                                        <!-- Base SVG icon wrapper -->
                                        <svg class="doc-icon-svg" viewBox="0 0 24 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            @php
                                                $color = '#1080D0'; // default blue (DOC)
                                                $text = strtoupper(substr($file->extension, 0, 3));
                                                if (in_array(strtolower($file->extension), ['pdf']))
                                                    $color = '#EA4335';
                                                if (in_array(strtolower($file->extension), ['csv', 'xls', 'xlsx']))
                                                    $color = '#34A853';
                                                if (in_array(strtolower($file->extension), ['jpg', 'png', 'jpeg']))
                                                    $color = '#F59E0B';
                                            @endphp
                                            <path
                                                d="M14 0H2C0.9 0 0 0.9 0 2V28C0 29.1 0.9 30 2 30H22C23.1 30 24 29.1 24 28V10L14 0Z"
                                                fill="white" stroke="{{ $color }}" stroke-width="2" />
                                            <path d="M14 0V10H24" fill="{{ $color }}" />
                                            <rect x="5" y="15" width="14" height="8" rx="1" fill="{{ $color }}" />
                                            <text x="12" y="21" fill="white" font-size="5" font-family="sans-serif"
                                                font-weight="bold" text-anchor="middle">{{ $text }}</text>
                                        </svg>
                                    </div>
                                </div>
                                <div class="doc-card-title" title="{{ $file->original_name }}"
                                    onclick="showPreview('{{ $file->id }}', '{{ $file->original_name }}', '{{ $file->creator->name ?? 'System' }}', '{{ $file->division->name ?? '-' }}', '{{ $file->created_at->format('d/m/y') }}', '{{ $file->extension }}', '{{ round($file->size / 1024, 2) }} KB', '{{ $file->visibility }}', {{ $canEdit }})"
                                    style="cursor:pointer;">
                                    {{ \Illuminate\Support\Str::limit($file->name, 20) }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($folders->isEmpty() && $files->isEmpty())
                        <div
                            style="grid-column: 1 / -1; text-align: center; color: #999; padding: 40px; border: 2px dashed #EAEAEA; border-radius: 16px;">
                            <i class="fas fa-box-open" style="font-size: 40px; margin-bottom: 15px; color:#D1D5DB;"></i>
                            <p>It's quiet in here... No files or folders yet!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Preview Sidebar (Right) -->
            <aside class="preview-sidebar">
                <div class="preview-title">Document Details</div>
                
                <div id="preview-filename" class="preview-filename">Select a file...</div>
                
                <div class="meta-list">
                    <div class="meta-item">
                        <span class="meta-label">Author</span>
                        <span class="meta-value" id="preview-author">-</span>
                    </div>
                    
                    <div class="meta-item">
                        <span class="meta-label">Division</span>
                        <span class="meta-value" id="preview-division">-</span>
                    </div>
                    
                    <div class="meta-item">
                        <span class="meta-label">Date Added</span>
                        <span class="meta-value" id="preview-date">-</span>
                    </div>
                    
                    <div class="meta-item">
                        <span class="meta-label">Type</span>
                        <span class="meta-value" id="preview-type">-</span>
                    </div>
                    
                    <div class="meta-item">
                        <span class="meta-label">Size</span>
                        <span class="meta-value" id="preview-size">-</span>
                    </div>
                </div>
            </aside>
        </main>
    </div>

    <!-- Modal Create Folder -->
    <div class="modal-overlay" id="modal-folder">
        <div class="modal-content">
            <h3><i class="fas fa-folder-plus" style="color:#FBBF24;"></i> Create New Folder</h3>
            <form action="{{ route('divisi.documents.storeFolder') }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $currentFolder ? $currentFolder->id : '' }}">
                <div class="form-group">
                    <label>Folder Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Invoices 2024" required>
                </div>
                <div class="form-group">
                    <label>Visibility</label>
                    <select name="visibility" class="form-control" required>
                        <option value="private">🔒 Private (My Division Only)</option>
                        <option value="public">🌍 Public (All Divisions)</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn"
                        onclick="document.getElementById('modal-folder').style.display='none'">Cancel</button>
                    <button type="submit" class="action-btn primary">Create Folder</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Upload File -->
    <div class="modal-overlay" id="modal-file">
        <div class="modal-content">
            <h3><i class="fas fa-cloud-upload-alt" style="color:#BA1D2E;"></i> Upload File</h3>
            <form action="{{ route('divisi.documents.storeFile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $currentFolder ? $currentFolder->id : '' }}">
                <div class="form-group">
                    <label>Select File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Visibility</label>
                    <select name="visibility" class="form-control" required>
                        <option value="private">🔒 Private (My Division Only)</option>
                        <option value="public">🌍 Public (All Divisions)</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn"
                        onclick="document.getElementById('modal-file').style.display='none'">Cancel</button>
                    <button type="submit" class="action-btn primary">Upload File</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Upload Folder -->
    <div class="modal-overlay" id="modal-upload-folder">
        <div class="modal-content">
            <h3><i class="fas fa-folder-open" style="color:#3b82f6;"></i> Upload Folder</h3>
            <form action="{{ route('divisi.documents.storeFolderUpload') }}" method="POST" enctype="multipart/form-data"
                id="upload-folder-form">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $currentFolder ? $currentFolder->id : '' }}">
                <div class="form-group">
                    <label>Select Local Folder</label>
                    <input type="file" name="files[]" id="folder-input" class="form-control" webkitdirectory directory
                        multiple required>
                </div>
                <div class="form-group">
                    <label>Visibility</label>
                    <select name="visibility" class="form-control" required>
                        <option value="private">🔒 Private (My Division Only)</option>
                        <option value="public">🌍 Public (All Divisions)</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn"
                        onclick="document.getElementById('modal-upload-folder').style.display='none'">Cancel</button>
                    <button type="submit" class="action-btn primary">Upload Folder</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rename/Edit Folder Modal -->
    <div class="modal-overlay" id="renameFolderModal">
        <div class="modal-content">
            <h3 id="renameFolderModalTitle">Edit Folder</h3>
            <form id="renameFolderForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Folder Name</label>
                    <input type="text" name="name" id="rename_folder_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Aksesibilitas (Visibility)</label>
                    <select name="visibility" id="rename_folder_visibility" class="form-control" required>
                        <option value="private">Private (Hanya Divisimu)</option>
                        <option value="public">Public (Semua Divisi)</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn"
                        onclick="document.getElementById('renameFolderModal').style.display='none'">Cancel</button>
                    <button type="submit" class="action-btn primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Rename/Edit File Modal -->
    <div class="modal-overlay" id="renameFileModal">
        <div class="modal-content">
            <h3 id="renameFileModalTitle">Edit File</h3>
            <form id="renameFileForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>File Name</label>
                    <input type="text" name="name" id="rename_file_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Aksesibilitas (Visibility)</label>
                    <select name="visibility" id="rename_file_visibility" class="form-control" required>
                        <option value="private">Private (Hanya Divisimu)</option>
                        <option value="public">Public (Semua Divisi)</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn"
                        onclick="document.getElementById('renameFileModal').style.display='none'">Cancel</button>
                    <button type="submit" class="action-btn primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleGlobalMenu() {
            const dropdown = document.getElementById('global-menu-dropdown');
            dropdown.style.display = dropdown.style.display === 'flex' ? 'none' : 'flex';
        }

        // Close global dropdown when clicking outside
        document.addEventListener('click', function (e) {
            const menu = document.getElementById('global-actions-menu');
            const dropdown = document.getElementById('global-menu-dropdown');
            if (menu && !menu.contains(e.target) && dropdown && dropdown.style.display === 'flex') {
                dropdown.style.display = 'none';
            }
        });

        function showPreview(id, name, author, division, date, type, size, visibility, canEdit) {
            // Remove 'selected' class from all cards
            document.querySelectorAll('.doc-card').forEach(el => el.classList.remove('selected'));
            
            // Add 'selected' class to the clicked card
            const activeCardId = type === 'Folder' ? 'card-folder-' + id : 'card-file-' + id;
            const activeCard = document.getElementById(activeCardId);
            if(activeCard) {
                activeCard.classList.add('selected');
            }

            document.getElementById('preview-filename').innerText = name;
            document.getElementById('preview-author').innerText = author;
            document.getElementById('preview-division').innerText = division;
            document.getElementById('preview-date').innerText = date;
            document.getElementById('preview-type').innerText = type.toUpperCase();
            document.getElementById('preview-size').innerText = size;

            // Global Actions Menu Logic
            const globalMenuBtn = document.getElementById('global-menu-btn');

            if (canEdit === true || canEdit === 'true' || canEdit === 1) {
                globalMenuBtn.disabled = false;
                globalMenuBtn.style.cursor = 'pointer';
                globalMenuBtn.style.opacity = '1';

                const editBtn = document.getElementById('global-edit-btn');
                const deleteForm = document.getElementById('global-delete-form');

                if (type === 'Folder') {
                    editBtn.onclick = () => openRenameFolderModal(id, name, visibility);
                    deleteForm.action = '/divisi/documents/folder/' + id;
                } else {
                    editBtn.onclick = () => openRenameFileModal(id, name, visibility);
                    deleteForm.action = '/divisi/documents/file/' + id;
                }
            } else {
                globalMenuBtn.disabled = true;
                globalMenuBtn.style.cursor = 'not-allowed';
                globalMenuBtn.style.opacity = '0.4';
                document.getElementById('global-menu-dropdown').style.display = 'none'; // Ensure dropdown is closed
            }
        }

        // Folder Upload Interceptor
        document.getElementById('upload-folder-form').addEventListener('submit', function (e) {
            const fileInput = document.getElementById('folder-input');
            const files = fileInput.files;

            for (let i = 0; i < files.length; i++) {
                const pathInput = document.createElement('input');
                pathInput.type = 'hidden';
                pathInput.name = 'paths[]';
                pathInput.value = files[i].webkitRelativePath;
                this.appendChild(pathInput);
            }
        });

        // SweetAlert2 Delete Confirmation
        function confirmDelete(event, form, type) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this " + type + "!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#BA1D2E',
                cancelButtonColor: '#999',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }

        // Edit Folder logic
        function openRenameFolderModal(id, currentName, currentVisibility) {
            document.getElementById('renameFolderForm').action = '/divisi/documents/folder/' + id;
            document.getElementById('rename_folder_name').value = currentName;
            document.getElementById('rename_folder_visibility').value = currentVisibility;
            document.getElementById('renameFolderModal').style.display = 'flex';
        }

        // Edit File logic
        function openRenameFileModal(id, currentName, currentVisibility) {
            document.getElementById('renameFileForm').action = '/divisi/documents/file/' + id;
            document.getElementById('rename_file_name').value = currentName;
            document.getElementById('rename_file_visibility').value = currentVisibility;
            document.getElementById('renameFileModal').style.display = 'flex';
        }
    </script>
</body>

</html>