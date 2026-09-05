<?php

namespace App\Http\Controllers;

use App\Models\User;

class LeaderboardController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')
            ->withSum(['setoran as poin_terkumpul' => fn ($q) => $q->where('status', 'disetujui')], 'poin')
            ->withCount(['setoran as jumlah_setoran' => fn ($q) => $q->where('status', 'disetujui')])
            ->orderByDesc('poin_terkumpul')
            ->orderBy('nama')
            ->get()
            ->map(function ($u) {
                $u->poin_terkumpul = (int) ($u->poin_terkumpul ?? 0);

                return $u;
            });

        $kelas = $siswa
            ->filter(fn ($u) => filled($u->kelas) && $u->kelas !== '-')
            ->groupBy('kelas')
            ->map(function ($grup, $namaKelas) {
                return (object) [
                    'kelas' => $namaKelas,
                    'poin_terkumpul' => (int) $grup->sum('poin_terkumpul'),
                    'jumlah_siswa' => $grup->count(),
                ];
            })
            ->sortByDesc('poin_terkumpul')
            ->values();

        $rankSaya = null;
        if (auth()->user()->role === 'siswa') {
            $rankSaya = $siswa->search(fn ($u) => $u->id === auth()->id());
            $rankSaya = $rankSaya === false ? null : $rankSaya + 1;
        }

        return view('leaderboard.index', [
            'siswa' => $siswa->take(50),
            'kelas' => $kelas,
            'rankSaya' => $rankSaya,
        ]);
    }
}
