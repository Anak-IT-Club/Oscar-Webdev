@extends('layouts.guest')

@section('content')
    <p class="text-center text-muted mb-4">
        Selamat datang di <strong>{{ config('app.name', 'Laravel') }}</strong>.
        Silakan masuk atau daftar untuk melanjutkan.
    </p>

    <div class="d-grid gap-2">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/home') }}" class="btn btn-primary">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login') }}</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">{{ __('Register') }}</a>
                @endif
            @endauth
        @endif
    </div>
@endsection
