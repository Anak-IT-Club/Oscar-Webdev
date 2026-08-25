@extends('layouts.app')

@section('title', 'Daftar Nasabah')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-people-fill me-2"></i> Data Nasabah Bank Sampah
            </h3>

            <div class="card-tools">
                <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Nasabah
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap mb-0">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Saldo</th>
                        <th class="text-end" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($nasabahs as $nasabah)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $nasabah->nis }}</td>
                            <td>{{ $nasabah->nama }}</td>
                            <td>{{ $nasabah->no_hp ?? '-' }}</td>
                            <td>
                                Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('nasabah.edit', $nasabah) }}"
                                  class="btn btn-sm btn-warning"
                                 title="Edit">
                               <i class="bi bi-pencil"></i>
                             </a>
                                   

                               <form action="{{ route('nasabah.destroy', $nasabah) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Yakin ingin menghapus nasabah {{ $nasabah->nama }}?')">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
        <i class="bi bi-trash"></i>
                                </button>
                                  </form>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada nasabah.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

