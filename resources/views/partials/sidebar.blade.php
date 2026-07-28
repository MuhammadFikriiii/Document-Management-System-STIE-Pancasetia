@if(Auth::check() && Auth::user()->role === 'admin')
    <aside class="sidebar admin-sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon"><i class="fas fa-shield-alt"></i></div>
            <div style="line-height: 1.2;">
                <span style="display: block; font-size: 10px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; font-weight: 500;">Admin Panel</span>
                <strong style="font-size: 14px; font-weight: 700; color: white;">STIE Pancasetia</strong>
            </div>
        </div>

        <div class="nav-section-label">Management</div>
        <div class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard Admin
            </a>
            <a href="{{ route('admin.divisions') }}" class="nav-item {{ request()->routeIs('admin.divisions*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Manajemen Divisi
            </a>
            <a href="{{ route('admin.documents') }}" class="nav-item {{ request()->routeIs('admin.documents*') ? 'active' : '' }}">
                <i class="fas fa-folder-open"></i> Semua Dokumen
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Manajemen User
            </a>
            <a href="{{ route('admin.logs') }}" class="nav-item {{ request()->routeIs('admin.logs*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Audit Log
            </a>
            <a href="{{ route('admin.trash') }}" class="nav-item {{ request()->routeIs('admin.trash*') ? 'active' : '' }}">
                <i class="fas fa-trash-alt"></i> Sampah / Recycle Bin
            </a>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="nav-item" style="background:none;border:none;width:100%;cursor:pointer;color:rgba(255,255,255,0.6);text-align:left;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>
@else
    <aside class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-cloud"></i> STIE Pancasetia
        </div>
        <div class="nav-menu">
            <a href="{{ route('divisi.dashboard') }}" class="nav-item {{ request()->routeIs('divisi.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('divisi.documents') }}" class="nav-item {{ request()->routeIs('divisi.documents*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Document
            </a>
        </div>
        <div class="sidebar-footer">
            <div style="padding: 12px 16px; margin-bottom: 6px; border-radius: 10px; background: rgba(255,255,255,0.07); display: flex; align-items: center; gap: 10px;">
                <div style="width:34px; height:34px; background: rgba(255,255,255,0.2); border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div style="overflow:hidden;">
                    <div style="font-size:13px; font-weight:600; color:white; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ Auth::user()->name ?? 'User' }}
                    </div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.5);">
                        {{ Auth::user()->division->name ?? 'Divisi' }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="nav-item" style="background:none; border:none; width:100%; cursor:pointer; color:rgba(255,255,255,0.6); font-size:15px; font-weight:500;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>
@endif
