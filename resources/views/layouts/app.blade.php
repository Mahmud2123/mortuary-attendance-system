<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Mortuary AMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <i class="bi bi-building"></i>
                <span>Mortuary AMS</span>
            </div>
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('bodies.*') ? 'active' : '' }}">
                    <a href="{{ route('bodies.index') }}"><i class="bi bi-person-lines-fill"></i> Bodies</a>
                </li>
                <li class="{{ request()->routeIs('chambers.*') ? 'active' : '' }}">
                    <a href="{{ route('chambers.index') }}"><i class="bi bi-snow"></i> Chambers</a>
                </li>
                <li class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <a href="{{ route('attendance.index') }}"><i class="bi bi-clock-history"></i> Attendance</a>
                </li>
                <li class="{{ request()->routeIs('releases.*') ? 'active' : '' }}">
                    <a href="{{ route('releases.index') }}"><i class="bi bi-box-arrow-right"></i> Releases</a>
                </li>
                <li class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <a href="{{ route('reports.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Reports</a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="sidebar-divider">Administration</li>
                <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}"><i class="bi bi-people"></i> Staff Management</a>
                </li>
                <li class="{{ request()->routeIs('audit.*') ? 'active' : '' }}">
                    <a href="{{ route('audit.index') }}"><i class="bi bi-shield-check"></i> Audit Logs</a>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Content -->
        <div class="main-content">
            <nav class="topbar">
                <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle"><i class="bi bi-list"></i></button>
                <div class="ms-auto d-flex align-items-center gap-3">
                    <span class="badge bg-secondary text-uppercase">{{ auth()->user()->role }}</span>
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-4 me-2"></i>
                            <span>{{ auth()->user()->full_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->staff_id }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-left"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show toast-alert" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show toast-alert" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
