<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @vite(['resources/js/adminlte.js'])
</head>
<body class="app">
    <div class="app-wrapper">
        <main class="app-main">
            <div class="app-content-wrapper d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-7 col-lg-5 col-xl-4">
                            <div class="text-center mb-3">
                                <a href="{{ url('/') }}" class="h4 text-decoration-none">
                                    <i class="bi bi-box-seam-fill me-2"></i>{{ config('app.name', 'Laravel') }}
                                </a>
                            </div>
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>
