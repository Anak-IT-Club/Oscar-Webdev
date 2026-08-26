<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Site')</title>
    @vite(['resources/js/auth.js'])
</head>
<body class="auth-page">
    <div class="auth-wrap">
        <aside class="auth-aside">
            <div class="auth-aside-inner">
                <a class="auth-brand" href="{{ url('/') }}">
                    <span class="brand-badge"><i class="bi bi-recycle"></i></span>
                    <span>Smart Site</span>
                </a>
                <h2 class="auth-aside-title">Tong Sampah Pintar untuk Sekolah Hijau</h2>
                <p class="auth-aside-text">Sistem berbasis IoT &amp; AI yang membantu siswa memilah sampah dan mengumpulkan poin otomatis.</p>
                <div class="auth-chips">
                    <span class="auth-chip"><i class="bi bi-cpu me-1"></i> AI Detection</span>
                    <span class="auth-chip"><i class="bi bi-award me-1"></i> + Poin</span>
                    <span class="auth-chip"><i class="bi bi-tree me-1"></i> Eco Friendly</span>
                </div>
            </div>
            <i class="bi bi-recycle auth-decor"></i>
        </aside>

        <main class="auth-main">
            <div class="auth-card-wrap">
                <div class="card auth-card">
                    <div class="card-body p-4 p-lg-5">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>
