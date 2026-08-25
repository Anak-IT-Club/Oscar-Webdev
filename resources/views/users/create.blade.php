@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-person-plus me-2"></i> Tambah User</h3>
        </div>

        <form method="POST" action="{{ route('users.store') }}">
            <div class="card-body">
                @include('users._form', ['user' => null])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Batal</a>
            </div>
        </form>
    </div>
@endsection
