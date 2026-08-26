<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'User Login')</title>
    @vite(['resources/js/landing.js'])
    <style>
        body.auth-page {
            font-family: "Segoe UI", system-ui, -apple-system, Roboto, Helvetica, Arial, sans-serif;
            color: var(--smart-text);
            background:
                radial-gradient(1100px 520px at 85% -10%, rgba(52, 168, 83, 0.20), transparent 60%),
                linear-gradient(180deg, var(--smart-green-light) 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--smart-green-dark);
            text-decoration: none;
        }

        .auth-brand .brand-badge {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--smart-accent), var(--smart-green-dark));
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            box-shadow: 0 12px 26px -10px rgba(21, 95, 44, 0.6);
        }

        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 26px 64px -26px rgba(21, 95, 44, 0.38);
            overflow: hidden;
        }

        .auth-card .form-label {
            font-weight: 600;
            color: var(--smart-green-dark);
        }

        .auth-card .form-control {
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
        }

        .auth-card .form-control:focus {
            border-color: var(--smart-accent);
            box-shadow: 0 0 0 0.2rem rgba(52, 168, 83, 0.18);
        }

        .auth-card .input-group-text {
            background: var(--smart-green-light);
            border-color: #d8e8dc;
            color: var(--smart-green);
            border-radius: 10px 0 0 10px;
        }

        .auth-card .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .auth-link {
            color: var(--smart-green);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link:hover {
            color: var(--smart-green-dark);
            text-decoration: underline;
        }

        .btn-auth {
            width: 100%;
        }
    </style>
</head>
<body class="auth-page">
    <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh; padding: 24px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5 col-xl-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
