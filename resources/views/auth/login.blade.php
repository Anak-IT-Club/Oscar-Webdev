@extends('layouts.guest')

@section('title', __('User Login'))
@section('brand_name', 'User Login')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="text-center mb-4">
        <span class="brand-badge d-inline-flex align-items-center justify-content-center mb-2"
              style="width:54px;height:54px;border-radius:14px;background:linear-gradient(135deg,var(--smart-accent),var(--smart-green-dark));color:#fff;font-size:1.6rem;box-shadow:0 12px 26px -10px rgba(21,95,44,0.6);">
            <i class="bi bi-recycle"></i>
        </span>
        <h1 class="h4 mb-1" style="color:var(--smart-green-darker);font-weight:800;">User Login</h1>
        <p class="text-muted small mb-0">Silakan masuk untuk melanjutkan ke akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-cta-primary btn-auth">
                <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
            </button>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>

        <hr>

        <div class="text-center">
            <a href="{{ route('register') }}" class="auth-link">{{ __('Register') }}</a>
        </div>
    </form>
@endsection
