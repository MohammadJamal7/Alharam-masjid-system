<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            direction: rtl;
        }
        .admin-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        .sider {
            width: 68px;
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(12px);
            box-shadow: 4px 0 24px 0 rgba(30,41,59,0.10);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            transition: width 0.35s cubic-bezier(.4,0,.2,1), background 0.25s, box-shadow 0.25s;
        }
        .sider:not(.sider-collapsed) {
            width: 210px;
            background: rgba(255,255,255,0.96);
            box-shadow: 8px 0 32px 0 rgba(30,41,59,0.13);
        }
        .sider-header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 68px;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        .sider-logo {
            width: 38px;
            height: 38px;
            background: #174032cc;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(23,64,50,0.10);
            transition: transform 0.22s cubic-bezier(.4,0,.2,1), box-shadow 0.22s;
        }
        .sider:not(.sider-collapsed) .sider-logo {
            transform: scale(1.08) rotate(-3deg);
            box-shadow: 0 4px 16px rgba(23,64,50,0.13);
        }
        .sider-toggle {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            color: #b0b6be;
            font-size: 1.5rem;
            padding: 0.3rem 0.5rem;
            border-radius: 8px;
            transition: background 0.18s, color 0.18s, right 0.35s cubic-bezier(.4,0,.2,1);
            position: fixed;
            right: 68px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 201;
            box-shadow: 0 2px 8px rgba(30,41,59,0.07);
            background: #fff;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sider:not(.sider-collapsed) ~ .sider-toggle {
            right: 210px;
        }
        .sider-toggle:hover {
            background: #f1f5f9;
            color: #174032;
        }
        .sider-toggle .chevron {
            transition: transform 0.35s cubic-bezier(.4,0,.2,1);
            display: inline-block;
        }
        .sider:not(.sider-collapsed) ~ .sider-toggle .chevron {
            transform: rotate(180deg);
        }
        .sider-nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            width: 100%;
        }
        .sider-link {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.95rem 1.2rem;
            color: #1e293b;
            text-decoration: none;
            font-size: 1.09rem;
            border-right: 3px solid transparent;
            border-radius: 0 18px 18px 0;
            transition: background 0.18s, color 0.18s, border-color 0.18s, padding 0.28s cubic-bezier(.4,0,.2,1), font-weight 0.18s;
            width: 100%;
            position: relative;
            will-change: background, color, border-color, padding;
        }
        .sider-link i {
            color: #b0b6be;
            font-size: 1.25em;
            min-width: 28px;
            text-align: center;
            transition: color 0.18s, transform 0.22s cubic-bezier(.4,0,.2,1), opacity 0.22s;
            opacity: 0.85;
        }
        .sider-link span {
            opacity: 0;
            max-width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.28s cubic-bezier(.4,0,.2,1), max-width 0.28s cubic-bezier(.4,0,.2,1), transform 0.28s cubic-bezier(.4,0,.2,1);
            font-weight: 500;
            transform: translateX(12px) scale(0.98);
        }
        .sider:not(.sider-collapsed) .sider-link span {
            opacity: 1;
            max-width: 160px;
            margin-right: 0.2rem;
            transform: translateX(0) scale(1);
        }
        .sider-link.active, .sider-link:hover {
            background: rgba(241,245,249,0.95);
            color: #174032;
            border-right: 3px solid #174032;
            font-weight: 700;
        }
        .sider-link.active i, .sider-link:hover i {
            color: #174032;
            transform: scale(1.13) rotate(-8deg);
            opacity: 1;
        }
        .sider-footer {
            width: 100%;
            padding: 1.2rem 0.5rem;
            font-size: 0.93rem;
            color: #b0b6be;
            text-align: center;
            border-top: none;
        }
        .main-content {
            flex: 1;
            margin-right: 68px;
            padding: 2.5rem 2.5rem 2.5rem 2rem;
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-right 0.35s cubic-bezier(.4,0,.2,1);
        }
        .sider:not(.sider-collapsed) ~ .main-content {
            margin-right: 210px;
        }
        @media (max-width: 900px) {
            .sider {
                width: 56px;
            }
            .sider:not(.sider-collapsed) {
                width: 160px;
            }
            .main-content {
                margin-right: 56px;
                padding: 1.2rem 1.2rem 1.2rem 1rem;
            }
            .sider-footer {
                font-size: 0.85rem;
            }
            .sider:not(.sider-collapsed) ~ .main-content {
                margin-right: 160px;
            }
        }
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="sider sider-collapsed" id="sider">
        <div class="sider-header">
            <div class="sider-logo">
                <i class="fas fa-mosque"></i>
            </div>
        </div>
        <nav class="sider-nav">
            <a href="{{ route('admin.dashboard') }}" class="sider-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}">
                <i class="fas fa-chart-bar"></i> <span>الرئيسية</span>
            </a>
            <a href="{{ route('masjids.index') }}" class="sider-link{{ request()->routeIs('masjids.*') ? ' active' : '' }}"><i class="fas fa-mosque"></i> <span>إدارة المساجد</span></a>
            <a href="{{ route('announcements.index') }}" class="sider-link{{ request()->routeIs('announcements.*') ? ' active' : '' }}"><i class="fas fa-bullhorn"></i> <span>إدارة الإعلانات</span></a>
            <a href="{{ route('locations.index') }}" class="sider-link{{ request()->routeIs('locations.*') ? ' active' : '' }}"><i class="fas fa-map-marker-alt"></i> <span>إدارة المواقع</span></a>
            <a href="{{ route('admin.admins.index') }}" class="sider-link{{ request()->routeIs('admin.admins.index') ? ' active' : '' }}"><i class="fas fa-users"></i> <span>إدارة المشرفين</span></a>
            <a href="#" class="sider-link" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"><i class="fas fa-sign-out-alt"></i> <span>تسجيل الخروج</span></a>
            <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
        <div class="sider-footer">
            &copy; {{ date('Y') }} إدارة المساجد
        </div>
    </aside>
    <button class="sider-toggle" id="siderToggle" aria-label="Toggle sidebar">
        <i class="fas fa-chevron-left chevron"></i>
    </button>
    <main class="main-content">
        @yield('content')
    </main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sider = document.getElementById('sider');
        const toggle = document.getElementById('siderToggle');
        toggle.addEventListener('click', function() {
            sider.classList.toggle('sider-collapsed');
        });
    });
    // No need for manual redirect, handled by backend
</script>
<!-- Bootstrap 5 JS (for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html> 