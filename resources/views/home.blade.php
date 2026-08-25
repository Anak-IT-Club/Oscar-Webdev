@extends('layouts.app')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-speedometer2 me-2"></i> {{ __('Dashboard') }}</h3>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <p class="mb-0">{{ __('You are logged in!') }}</p>
        </div>
    </div>
@endsection
