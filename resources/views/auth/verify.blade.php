@extends('layouts.guest')

@section('title', __('Verify Your Email Address'))

@section('content')
    <p class="text-center text-muted mb-3">
        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
    </p>

    <form class="text-center" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
            {{ __('click here to request another') }}
        </button>.
    </form>
@endsection
