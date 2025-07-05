<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'DTI NCMAP System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
        }
        .sidebar .nav-link {
            color: #333;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .table-responsive {
            border-radius: 0.375rem;
        }
        .map-container {
            height: 500px;
            border-radius: 0.375rem;
        }
        .staff-card {
            transition: transform 0.2s;
        }
        .staff-card:hover {
            transform: translateY(-2px);
        }
        .reminder-high {
            border-left: 4px solid #dc3545;
        }
        .reminder-medium {
            border-left: 4px solid #ffc107;
        }
        .reminder-low {
            border-left: 4px solid #198754;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('map.index') }}">
                <i class="bi bi-geo-alt-fill"></i>
                DTI NCMAP System
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('map.*') ? 'active' : '' }}" href="{{ route('map.index') }}">
                            <i class="bi bi-map"></i> Map
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('map.staff.directory') ? 'active' : '' }}" href="{{ route('map.staff.directory') }}">
                            <i class="bi bi-people"></i> Staff Directory
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Admin Dashboard
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text">{{ auth()->user()->email }}</span></li>
                                <li><span class="dropdown-item-text text-muted">{{ ucfirst(auth()->user()->user_type) }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @if(auth()->check() && auth()->user()->isAdmin() && request()->routeIs('admin.*'))
                <!-- Admin Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.offices.*') ? 'active' : '' }}" href="{{ route('admin.offices.index') }}">
                                    <i class="bi bi-building"></i> Office Locations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}">
                                    <i class="bi bi-people"></i> Staff Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.reminders.*') ? 'active' : '' }}" href="{{ route('admin.reminders.index') }}">
                                    <i class="bi bi-alarm"></i> Reminders
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @else
                <!-- Full width content for non-admin pages -->
                <main class="col-12 px-4">
            @endif
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
