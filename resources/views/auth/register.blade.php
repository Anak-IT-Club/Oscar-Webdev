@extends('layouts.guest')

@section('title', __('Register'))

@section('content')
    <div class="auth-head">
        <span class="auth-logo"><i class="bi bi-person-plus"></i></span>
        <h1 class="auth-head-title">Register</h1>
        <p class="auth-head-sub">Buat akun Smart Site untuk mulai mengumpulkan poin.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">{{ __('Nama') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input id="nama" type="text"
                       class="form-control @error('nama') is-invalid @enderror"
                       name="nama" value="{{ old('nama') }}" required autocomplete="name" autofocus>
                @error('nama')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email Address') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email">
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
                       name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input id="password-confirm" type="password" class="form-control"
                       name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <button type="submit" class="btn btn-cta-primary w-100">
            <i class="bi bi-person-plus me-1"></i> {{ __('Register') }}
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="auth-link">{{ __('Sudah punya akun? Login') }}</a>
        </div>
    </form>
@endsection
