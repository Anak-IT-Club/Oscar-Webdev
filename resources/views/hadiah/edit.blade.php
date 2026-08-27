@extends('layouts.app')

@section('title', 'Edit Hadiah')

@section('content')
    <div class="contact-card p-4 mx-auto reveal" style="max-width:720px;">
        <h3 class="section-title mb-3">
            <i class="bi bi-pencil-square me-2"></i> Edit Hadiah
        </h3>

        <form action="{{ route('hadiah.update', $hadiah) }}" method="POST">
            @include('hadiah.form')

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('hadiah.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-cta-primary">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
@endsection
