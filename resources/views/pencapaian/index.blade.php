@extends('layouts.app')

@section('title', 'Pencapaian')

@section('content')
    <div class="dash-head">
        <div>
            <h1 class="dash-title">Pencapaian &amp; Misi 🎯</h1>
            <p class="dash-sub">Kumpulkan badge dan selesaikan misi mingguan dari aktivitas memilah sampahmu.</p>
        </div>
        <span class="dash-role">{{ $ringkas['earned'] }}/{{ $ringkas['total'] }} badge</span>
    </div>

    {{-- Misi mingguan --}}
    <div class="dash-card p-4 mb-3" style="height:auto;">
        <h2 class="dash-title h5 mb-3"><i class="bi bi-calendar-week me-1"></i> Misi Minggu Ini</h2>
        <div class="row g-3">
            @foreach ($misi as $m)
                <div class="col-md-4">
                    <div class="misi-card {{ $m['done'] ? 'done' : '' }}">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi {{ $m['ikon'] }}"></i>
                            <span class="fw-semibold">{{ $m['nama'] }}</span>
                            @if ($m['done'])<i class="bi bi-check-circle-fill ms-auto" style="color:var(--smart-green)"></i>@endif
                        </div>
                        <div class="progress" style="height:8px;">
                            <div class="progress-bar bg-success" style="width:{{ $m['persen'] }}%"></div>
                        </div>
                        <div class="small text-muted mt-1">{{ $m['now'] }} / {{ $m['target'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Badge --}}
    <div class="dash-card p-4" style="height:auto;">
        <h2 class="dash-title h5 mb-3"><i class="bi bi-award-fill me-1"></i> Koleksi Badge</h2>
        <div class="row g-3">
            @foreach ($badges as $b)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="badge-card {{ $b['earned'] ? 'earned' : 'locked' }}">
                        <span class="badge-ic"><i class="bi {{ $b['ikon'] }}"></i></span>
                        <div class="badge-nama">{{ $b['nama'] }}</div>
                        <div class="badge-desc">{{ $b['desc'] }}</div>
                        @if ($b['earned'])
                            <span class="badge text-bg-success mt-1"><i class="bi bi-check-lg"></i> Didapat</span>
                        @elseif (!is_null($b['target']))
                            <div class="progress mt-2" style="height:6px;">
                                <div class="progress-bar bg-secondary" style="width:{{ (int) min(100, round(($b['now'] ?? 0) / $b['target'] * 100)) }}%"></div>
                            </div>
                            <div class="small text-muted mt-1">{{ $b['now'] }} / {{ $b['target'] }}</div>
                        @else
                            <span class="badge text-bg-light text-muted mt-1">Terkunci</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .misi-card { border: 1px solid #e6efe8; border-radius: 12px; padding: 14px; height: 100%; }
        .misi-card.done { background: var(--smart-green-light); border-color: var(--smart-accent); }
        .misi-card .bi { color: var(--smart-green); }
        .badge-card {
            border: 1px solid #e6efe8; border-radius: 14px; padding: 16px; text-align: center; height: 100%;
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .badge-card.earned { background: #fff; }
        .badge-card.earned:hover { transform: translateY(-3px); box-shadow: 0 14px 30px -20px rgba(21,95,44,.5); }
        .badge-card.locked { background: #f4f6f5; opacity: .7; }
        .badge-ic {
            width: 56px; height: 56px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.6rem; margin-bottom: 8px;
        }
        .badge-card.earned .badge-ic { background: linear-gradient(135deg, var(--smart-accent), var(--smart-green-dark)); color: #fff; }
        .badge-card.locked .badge-ic { background: #e3e8e4; color: #9aa79e; }
        .badge-nama { font-weight: 700; color: var(--smart-green-dark); font-size: .95rem; }
        .badge-card.locked .badge-nama { color: #7c887f; }
        .badge-desc { font-size: .78rem; color: var(--smart-muted); margin-top: 2px; }
    </style>
@endsection
