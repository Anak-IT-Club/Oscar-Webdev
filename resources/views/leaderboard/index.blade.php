@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Leaderboard 🏆</h1>
            <p class="dash-sub">Peringkat berdasarkan total poin yang dikumpulkan dari setoran sampah.</p>
        </div>
        @if ($rankSaya)
            <span class="dash-role">Peringkat kamu: #{{ $rankSaya }}</span>
        @endif
    </div>

    <div class="row g-3">
        {{-- Peringkat Kelas --}}
        <div class="col-lg-5">
            <div class="dash-card p-4 h-100">
                <h2 class="dash-title h5 mb-3"><i class="bi bi-mortarboard-fill me-1"></i> Peringkat Kelas</h2>
                @forelse ($kelas as $i => $k)
                    <div class="lb-row {{ $i === 0 ? 'lb-top' : '' }}">
                        <span class="lb-rank">
                            @if ($i === 0) 🥇 @elseif ($i === 1) 🥈 @elseif ($i === 2) 🥉 @else {{ $i + 1 }} @endif
                        </span>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $k->kelas }}</div>
                            <div class="small text-muted">{{ $k->jumlah_siswa }} siswa</div>
                        </div>
                        <span class="lb-poin">{{ number_format($k->poin_terkumpul, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada data kelas.</p>
                @endforelse
            </div>
        </div>

        {{-- Peringkat Siswa --}}
        <div class="col-lg-7">
            <div class="dash-card p-4 h-100">
                <h2 class="dash-title h5 mb-3"><i class="bi bi-people-fill me-1"></i> Peringkat Siswa</h2>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:52px;">#</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th class="text-center">Setoran</th>
                                <th class="text-end">Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $i => $s)
                                <tr class="{{ $s->id === auth()->id() ? 'lb-me' : '' }}">
                                    <td>
                                        @if ($i === 0) 🥇 @elseif ($i === 1) 🥈 @elseif ($i === 2) 🥉 @else <span class="text-muted">{{ $i + 1 }}</span> @endif
                                    </td>
                                    <td class="fw-semibold">
                                        {{ $s->nama }}
                                        @if ($s->id === auth()->id())<span class="badge text-bg-success ms-1">Kamu</span>@endif
                                    </td>
                                    <td class="small">{{ $s->kelas ?? '-' }}</td>
                                    <td class="text-center">{{ $s->jumlah_setoran }}</td>
                                    <td class="text-end fw-semibold" style="color:var(--smart-green-dark)">
                                        {{ number_format($s->poin_terkumpul, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Belum ada siswa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .lb-row {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 8px; border-bottom: 1px solid #eef3ee;
        }
        .lb-row:last-child { border-bottom: 0; }
        .lb-top { background: var(--smart-green-light); border-radius: 12px; }
        .lb-rank {
            width: 34px; text-align: center; font-weight: 800; font-size: 1.1rem;
            color: var(--smart-green-dark);
        }
        .lb-poin { font-weight: 800; color: var(--smart-green-dark); }
        .lb-me { background: var(--smart-green-light); }
    </style>
@endsection
