<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Folder: {{ $rootFolder->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #F8F9FA; color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        .header { background: #BA1D2E; color: white; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .header h1 { font-size: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; flex-grow: 1; width: 100%; }
        
        .breadcrumb { background: white; padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #EAEAEA; display: flex; align-items: center; gap: 8px; font-weight: 500; color: #555; }
        .breadcrumb a { color: #BA1D2E; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        
        .doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 20px; justify-items: center; }
        .doc-card { background: white; border: 1px solid #EAEAEA; border-radius: 16px; padding: 15px 10px; width: 145px; display: flex; flex-direction: column; align-items: center; cursor: pointer; text-decoration: none; color: inherit; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .doc-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.08); border-color: #BA1D2E; }
        
        .doc-icon-wrapper { display: flex; align-items: center; justify-content: center; margin-bottom: 12px; width: 80px; height: 80px; }
        .doc-card-title { font-size: 13px; font-weight: 600; text-align: center; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .empty-state i { font-size: 50px; margin-bottom: 15px; color: #D1D5DB; }
        
        .footer { text-align: center; padding: 20px; font-size: 13px; color: #777; border-top: 1px solid #EAEAEA; margin-top: auto; }
        
        /* Modal for preview */
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 100; align-items: center; justify-content: center; flex-direction: column; padding: 20px; }
        .modal-header { width: 100%; max-width: 1000px; display: flex; justify-content: space-between; color: white; padding-bottom: 15px; }
        .modal-content { width: 100%; max-width: 1000px; height: 80vh; background: #fff; border-radius: 12px; overflow: hidden; }
        .modal-content iframe, .modal-content img { width: 100%; height: 100%; border: none; object-fit: contain; background: #f0f0f0; }
        .close-btn { background: rgba(255,255,255,0.2); border: none; color: white; padding: 5px 12px; border-radius: 6px; cursor: pointer; }
        .close-btn:hover { background: rgba(255,255,255,0.3); }
        .btn-download { display: inline-flex; align-items: center; gap: 8px; background: #16a34a; color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; margin-top: 20px; }
    </style>
</head>
<body>

    <div class="header">
        <h1><i class="fas fa-folder-open"></i> Shared Folder</h1>
        <div><i class="fas fa-shield-alt"></i> Public Access</div>
    </div>

    <div class="container">
        <div class="breadcrumb">
            @if($currentFolder->id == $rootFolder->id)
                <i class="fas fa-folder"></i> {{ $rootFolder->name }}
            @else
                <a href="{{ route('share.folder', ['token' => $token, 'folder_id' => $rootFolder->id]) }}">
                    <i class="fas fa-folder"></i> {{ $rootFolder->name }}
                </a>
                <i class="fas fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
                @if($currentFolder->parent_id && $currentFolder->parent_id != $rootFolder->id)
                    ... <i class="fas fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
                @endif
                <span>{{ $currentFolder->name }}</span>
            @endif
        </div>

        <div class="doc-grid">
            @foreach($folders as $folder)
                <a href="{{ route('share.folder', ['token' => $token, 'folder_id' => $folder->id]) }}" class="doc-card">
                    <div class="doc-icon-wrapper" style="color: #BA1D2E;">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="width:70px; height:70px;">
                            <rect x="20" y="25" width="60" height="40" rx="3" fill="#ffffff" stroke="#e0e0e0" stroke-width="2" />
                            <path d="M10,25 h25 l10,10 h45 a5,5 0 0 1 5,5 v40 a5,5 0 0 1 -5,5 h-80 a5,5 0 0 1 -5,-5 v-50 a5,5 0 0 1 5,-5 Z" fill="currentColor" opacity="0.8" />
                            <path d="M5,45 h90 l-5,40 h-80 Z" fill="currentColor" />
                        </svg>
                    </div>
                    <div class="doc-card-title" title="{{ $folder->name }}">{{ $folder->name }}</div>
                </a>
            @endforeach

            @foreach($files as $file)
                @php
                    $previewUrl = route('share.previewFile', ['token' => $token, 'file_id' => $file->id]);
                    $downloadUrl = route('share.downloadFile', ['token' => $token, 'file_id' => $file->id]);
                    
                    $color = '#1080D0';
                    if (in_array(strtolower($file->extension), ['pdf'])) $color = '#EA4335';
                    if (in_array(strtolower($file->extension), ['csv', 'xls', 'xlsx'])) $color = '#34A853';
                    if (in_array(strtolower($file->extension), ['jpg', 'png', 'jpeg', 'gif', 'webp'])) $color = '#F59E0B';
                @endphp
                <div class="doc-card" onclick="openPreview('{{ $file->original_name }}', '{{ strtolower($file->extension) }}', '{{ $previewUrl }}', '{{ $downloadUrl }}')">
                    <div class="doc-icon-wrapper">
                        <svg viewBox="0 0 24 30" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:50px; height:60px;">
                            <path d="M14 0H2C0.9 0 0 0.9 0 2V28C0 29.1 0.9 30 2 30H22C23.1 30 24 29.1 24 28V10L14 0Z" fill="white" stroke="{{ $color }}" stroke-width="2" />
                            <path d="M14 0V10H24" fill="{{ $color }}" />
                            <rect x="5" y="15" width="14" height="8" rx="1" fill="{{ $color }}" />
                            <text x="12" y="21" fill="white" font-size="5" font-family="sans-serif" font-weight="bold" text-anchor="middle">{{ strtoupper(substr($file->extension, 0, 3)) }}</text>
                        </svg>
                    </div>
                    <div class="doc-card-title" title="{{ $file->original_name }}">{{ \Illuminate\Support\Str::limit($file->name, 20) }}</div>
                </div>
            @endforeach
        </div>

        @if($folders->isEmpty() && $files->isEmpty())
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>This folder is empty.</p>
            </div>
        @endif
    </div>
    
    <div class="footer">
        Document Management System &copy; {{ date('Y') }} STIE Pancasetia
    </div>

    <!-- Preview Modal -->
    <div class="modal" id="previewModal">
        <div class="modal-header">
            <h3 id="modalTitle">File Name</h3>
            <div>
                <a href="#" id="modalDownloadBtn" class="close-btn" style="background:#16a34a; text-decoration:none; margin-right:10px;"><i class="fas fa-download"></i> Download</a>
                <button class="close-btn" onclick="closePreview()"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
        <div class="modal-content" id="modalContent"></div>
    </div>

    <script>
        function openPreview(name, ext, previewUrl, downloadUrl) {
            document.getElementById('modalTitle').innerText = name;
            document.getElementById('modalDownloadBtn').href = downloadUrl;
            
            const content = document.getElementById('modalContent');
            const images = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (images.includes(ext)) {
                content.innerHTML = `<img src="${previewUrl}" alt="${name}">`;
            } else if (ext === 'pdf') {
                content.innerHTML = `<iframe src="${previewUrl}"></iframe>`;
            } else {
                content.innerHTML = `<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:#666;">
                    <i class="fas fa-file-alt" style="font-size:60px; margin-bottom:20px; color:#ccc;"></i>
                    <p style="margin-bottom:20px; font-weight:500;">Preview not available for this file type.</p>
                    <a href="${downloadUrl}" class="btn-download"><i class="fas fa-download"></i> Download File</a>
                </div>`;
            }
            
            document.getElementById('previewModal').style.display = 'flex';
        }

        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
            document.getElementById('modalContent').innerHTML = '';
        }
    </script>
</body>
</html>
