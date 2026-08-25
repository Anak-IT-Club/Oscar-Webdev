@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title"><i class="bi bi-pencil-square me-2"></i> Edit Data User</h3>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}">
            <div class="card-body">
                @include('users._form', ['user' => $user])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i> Update
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Batal</a>
            </div>
        </form>
    </div>
@endsection
