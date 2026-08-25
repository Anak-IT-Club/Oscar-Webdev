@extends('layouts.guest')

@section('title', __('Login'))

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

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

        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>

        <hr>

        <div class="text-center">
            <a href="{{ route('register') }}" class="text-decoration-none">{{ __('Register') }}</a>
        </div>
    </form>
@endsection
