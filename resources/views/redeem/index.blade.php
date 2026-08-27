@extends('layouts.app')

@section('title', 'Redeem Poin')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Redeem Poin</h1>
            <p class="dash-sub">Tukarkan poin kamu dengan hadiah menarik 🎁</p>
        </div>
        <span class="dash-role">Poin: {{ number_format(auth()->user()->poin, 0, ',', '.') }}</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="row g-3">
        @forelse ($hadiahs as $hadiah)
            <div class="col-sm-6 col-lg-4">
                <div class="dash-card p-4 h-100 d-flex flex-column">
                    <div class="icon mb-2" style="width:48px;height:48px;font-size:1.4rem;">
                        <i class="bi bi-gift"></i>
                    </div>
                    <h3 class="dash-title h5 mb-1">{{ $hadiah->nama_hadiah }}</h3>
                    <div class="dash-sub mb-3">{{ number_format($hadiah->poin, 0, ',', '.') }} poin</div>

                    @if (auth()->user()->poin >= $hadiah->poin)
                        <form action="{{ route('redeem.store') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="hadiah_id" value="{{ $hadiah->id }}">
                            <button type="submit" class="btn btn-cta-primary w-100">
                                <i class="bi bi-arrow-left-right me-1"></i> Tukar
                            </button>
                        </form>
                    @else
                        <button type="button" class="btn btn-outline-secondary w-100 mt-auto" disabled>
                            Poin kurang
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="dash-card p-4 text-center text-muted">Belum ada hadiah yang bisa ditukar.</div>
            </div>
        @endforelse
    </div>

    @if ($riwayat->isNotEmpty())
        <div class="dash-card p-4 mt-4">
            <h2 class="dash-title h5 mb-3">Riwayat Tukar</h2>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Hadiah</th>
                            <th>Poin Dipakai</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $item)
                            <tr>
                                <td>{{ $item->hadiah->nama_hadiah ?? '-' }}</td>
                                <td>{{ number_format($item->poin_dipakai, 0, ',', '.') }}</td>
                                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
