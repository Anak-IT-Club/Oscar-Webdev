@extends('layouts.guest')

@section('title', __('User Login'))

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    <div class="auth-head">
        <span class="auth-logo"><i class="bi bi-recycle"></i></span>
        <h1 class="auth-head-title">User Login</h1>
        <p class="auth-head-sub">Silakan masuk untuk melanjutkan ke akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                 <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email', request()->cookie('remember_email')) }}" required autocomplete="off" autofocus readonly onfocus="this.removeAttribute('readonly')">
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
                       name="password" required autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                 @error('password')
                     <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                 @enderror
            </div>
        </div>

        <div class="mb-4 form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ (old('remember') || request()->cookie('remember_email')) ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
        </div>

        <button type="submit" class="btn btn-cta-primary w-100 mb-3">
            <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
        </button>

        <div class="text-center">
            <a href="{{ route('register') }}" class="auth-link">{{ __('Belum punya akun? Register') }}</a>
        </div>
    </form>
@endsection
