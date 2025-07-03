<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard BTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-width-collapsed: 70px;
            --topbar-height: 70px;
            --primary-color: #2c3e50;
            --secondary-color: #f8f9fa;
            --accent-color: #3498db;
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
        }

        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, var(--primary-color) 0%, #34495e 100%);
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        #sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        #content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: calc(100vh - var(--topbar-height));
            margin-top: var(--topbar-height);
            background-color: #f5f6fa;
            transition: all 0.3s;
        }

        #content.expanded {
            margin-left: var(--sidebar-width-collapsed);
        }

        .sidebar-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: flex-start;
            font-weight: 700;
            font-size: 1.4rem;
            color: white;
            text-decoration: none;
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            letter-spacing: 1px;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-brand i {
            margin-right: 10px;
            font-size: 1.6rem;
            min-width: 30px;
        }

        .sidebar-brand-text {
            transition: opacity 0.3s;
        }

        .collapsed .sidebar-brand-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        .sidebar-item {
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: all 0.3s;
            margin: 4px 0;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .sidebar-item:hover, .sidebar-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent-color);
        }

        .sidebar-item i {
            margin-right: 12px;
            font-size: 1.2rem;
            min-width: 24px;
        }

        .sidebar-item-text {
            transition: opacity 0.3s;
        }

        .collapsed .sidebar-item-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        #topbar {
            height: var(--topbar-height);
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 999;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            transition: all 0.3s;
        }

        #topbar.expanded {
            left: var(--sidebar-width-collapsed);
        }

        .sidebar-toggle {
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--text-primary);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #edf2f7;
            padding: 1.25rem 1.5rem;
            border-radius: 15px 15px 0 0;
            font-weight: 600;
        }

        .stat-card {
            border-left: 5px solid var(--accent-color);
            background: linear-gradient(135deg, white 0%, #f8f9fa 100%);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-card .stat-title {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 1px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 10px 0;
        }

        .stat-card .stat-icon {
            font-size: 2rem;
            color: var(--accent-color);
            opacity: 0.8;
        }

        .dropdown-toggle {
            background-color: transparent;
            border: none;
            color: var(--text-primary);
            font-weight: 500;
            padding: 8px 15px;
        }

        .dropdown-toggle:hover {
            background-color: #f8f9fa;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 10px;
        }

        .dropdown-item {
            padding: 8px 20px;
            color: var(--text-primary);
            border-radius: 5px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--accent-color);
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 240px;
            }

            .card {
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            #sidebar {
                width: var(--sidebar-width);
                transform: translateX(-100%);
            }

            #sidebar.mobile-shown {
                transform: translateX(0);
            }

            #content, #topbar {
                margin-left: 0;
                left: 0;
                width: 100%;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .mobile-overlay.shown {
                display: block;
            }
        }

        @media (max-width: 576px) {
            #content {
                padding: 20px 15px;
            }

            #topbar {
                padding: 0 15px;
            }

            .stat-card .stat-value {
                font-size: 1.5rem;
            }

            .stat-card .stat-icon {
                font-size: 1.5rem;
            }
        }

        /* Table responsive */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Make form elements responsive */
        .form-control, .form-select, .btn {
            max-width: 100%;
        }

        /* Image responsive in tables */
        .table img {
            max-width: 100px;
            height: auto;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Sidebar -->
    <div id="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="bi bi-book-half"></i> <span class="sidebar-brand-text">Buku Tahunan</span>
        </a>
        <div class="py-4">
            <a href="{{ route('dashboard') }}" class="d-block sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> <span class="sidebar-item-text">Dashboard</span>
            </a>
            <a href="{{ route('tahuns.index') }}" class="d-block sidebar-item {{ request()->routeIs('tahuns.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> <span class="sidebar-item-text">Tahun Akademik</span>
            </a>
            <a href="{{ route('kategoris.index') }}" class="d-block sidebar-item {{ request()->routeIs('kategoris.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> <span class="sidebar-item-text">Kategori</span>
            </a>
            <a href="{{ route('bukus.index') }}" class="d-block sidebar-item {{ request()->routeIs('bukus.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark"></i> <span class="sidebar-item-text">Buku Tahunan</span>
            </a>
        </div>
    </div>

    <!-- Topbar -->
    <div id="topbar">
        <div class="sidebar-toggle d-flex align-items-center">
            <i class="bi bi-list" id="sidebarToggle"></i>
        </div>
        <div class="dropdown">
            <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i> Admin
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
        </div>
    </div>

    <!-- Content -->
    <div id="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const topbar = document.getElementById('topbar');
            const mobileOverlay = document.getElementById('mobileOverlay');

            // Check window width on load
            checkWindowSize();

            // Check window width on resize
            window.addEventListener('resize', checkWindowSize);

            function checkWindowSize() {
                if (window.innerWidth < 768) {
                    // Mobile view
                    sidebar.classList.remove('collapsed');
                    content.classList.remove('expanded');
                    topbar.classList.remove('expanded');
                } else {
                    // Remove mobile specific classes
                    sidebar.classList.remove('mobile-shown');
                    mobileOverlay.classList.remove('shown');
                }
            }

            sidebarToggle.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    // Mobile toggle
                    sidebar.classList.toggle('mobile-shown');
                    mobileOverlay.classList.toggle('shown');
                } else {
                    // Desktop toggle
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('expanded');
                    topbar.classList.toggle('expanded');
                }
            });

            // Close sidebar when clicking on overlay (mobile)
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-shown');
                mobileOverlay.classList.remove('shown');
            });

            // Add smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
