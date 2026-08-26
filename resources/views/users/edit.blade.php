@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="contact-card p-4 mx-auto reveal" style="max-width:720px;">
        <h3 class="section-title mb-3">
            <i class="bi bi-pencil-square me-2"></i> Edit User
        </h3>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @include('users._form', ['user' => $user])

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-cta-primary">
                    <i class="bi bi-save me-1"></i> Update User
                </button>
            </div>
        </form>
    </div>
@endsection
