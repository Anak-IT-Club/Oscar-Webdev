@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 reveal">
        <div>
            <span class="text-uppercase fw-semibold" style="color:var(--smart-accent);letter-spacing:.08em;">Manajemen</span>
            <h2 class="section-title mt-1 mb-0">Daftar User</h2>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-cta-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="contact-card p-4 reveal">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>No. HP</th>
                        <th>Poin</th>
                        <th>Role</th>
                        <th class="text-end" style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->nisn ?? '-' }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->kelas ?? '-' }}</td>
                            <td>{{ $user->jurusan ?? '-' }}</td>
                            <td>{{ $user->no_hp ?? '-' }}</td>
                            <td>{{ number_format($user->poin, 0, ',', '.') }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="badge text-bg-danger">Admin</span>
                                @else
                                    <span class="badge text-bg-success">Siswa</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus user {{ $user->nama }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">Belum ada user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
