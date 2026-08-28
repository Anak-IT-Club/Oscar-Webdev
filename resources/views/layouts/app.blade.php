<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Site')</title>
    @vite(['resources/js/adminlte.js', 'resources/js/dashboard.js'])
</head>
<body class="app sidebar-collapse">
    <div class="app-wrapper">

        {{-- Navbar --}}
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center side-brand-li">
                        <a class="side-brand" href="{{ route('home') }}">
                            <span class="badge-logo"><i class="bi bi-recycle"></i></span>
                            <span>Smart Site</span>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
                                <span class="me-1">{{ Auth::user()->nama }}</span>
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        {{-- Sidebar --}}
        <aside class="app-sidebar">
            <div class="sidebar-brand">
                <a class="brand-link" href="{{ route('home') }}">
                    <span class="brand-badge"><i class="bi bi-recycle"></i></span>
                    <span class="brand-text">Smart Site</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="menu-label">Menu</div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu" data-lte-toggle="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid-1x2-fill"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @if (auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sampah.index') }}" class="nav-link {{ request()->routeIs('sampah.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-recycle"></i>
                                <p>Sampah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('setoran.index') }}" class="nav-link {{ request()->routeIs('setoran.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-arrow-down-circle"></i>
                                <p>Setoran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hadiah.index') }}" class="nav-link {{ request()->routeIs('hadiah.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-gift"></i>
                                <p>Hadiah</p>
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ route('scanner.index') }}" class="nav-link {{ request()->routeIs('scanner.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-camera-fill"></i>
                                <p>Scan Sampah (AI)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('redeem.index') }}" class="nav-link {{ request()->routeIs('redeem.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-gift"></i>
                                <p>Redeem Poin</p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-circle"></i>
                                <p>Profil</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="side-user">
                <span class="avatar" id="sideAvatar" data-initial="{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}">
                    @if (Auth::user()->foto)
                        <img src="{{ asset('foto_profil/'.Auth::user()->foto) }}" alt="Foto" class="rounded-circle" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    @else
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    @endif
                </span>
                <div>
                    <div class="u-name">{{ Auth::user()->nama }}</div>
                    <div class="u-role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <main class="app-main">
            <div class="app-content-wrapper">
                <div class="container-fluid py-3">
                    @yield('content')
                </div>
            </div>
        </main>

    </div>
    @stack('scripts')
</body>
</html>
