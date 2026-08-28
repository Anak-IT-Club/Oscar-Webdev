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
    <a class="auth-back" href="{{ url('/') }}" title="Kembali ke beranda">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div class="auth-wrap">
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
