<?php

namespace App\Services;

use App\Models\Setoran;
use App\Models\User;
use Illuminate\Support\Carbon;

class AchievementService
{
    /**
     * Hitung badge & misi untuk seorang siswa berdasarkan data setoran.
     *
     * @return array{badges: array<int,array>, misi: array<int,array>, ringkas: array}
     */
    public function for(User $user): array
    {
        $setoran = $user->setoran()->get();
        $totalSetoran = $setoran->count();
        $totalPoin = (int) $setoran->sum('poin');
        $jenisUnik = $setoran->pluck('jenis_sampah')->unique();
        $b3 = $setoran->where('jenis_sampah', 'B3')->count();
        $hariUnik = $setoran->map(fn ($s) => $s->created_at->toDateString())->unique()->count();

        // peringkat siswa (berdasarkan poin terkumpul)
        $rank = User::where('role', 'siswa')
            ->withSum('setoran as p', 'poin')->orderByDesc('p')->pluck('id')
            ->search($user->id);
        $rank = $rank === false ? null : $rank + 1;

        $badge = fn ($key, $nama, $ikon, $desc, $earned, $now = null, $target = null) => compact('key', 'nama', 'ikon', 'desc', 'earned', 'now', 'target');

        $badges = [
            $badge('pertama', 'Langkah Pertama', 'bi-flag-fill', 'Melakukan setoran pertama', $totalSetoran >= 1, $totalSetoran, 1),
            $badge('rajin', 'Rajin Memilah', 'bi-recycle', 'Mengumpulkan 10 setoran', $totalSetoran >= 10, $totalSetoran, 10),
            $badge('kolektor', 'Sang Kolektor', 'bi-collection-fill', 'Mengumpulkan 25 setoran', $totalSetoran >= 25, $totalSetoran, 25),
            $badge('poin50', 'Poin Perdana', 'bi-coin', 'Mengumpulkan 50 poin', $totalPoin >= 50, $totalPoin, 50),
            $badge('poin200', 'Kaya Poin', 'bi-cash-stack', 'Mengumpulkan 200 poin', $totalPoin >= 200, $totalPoin, 200),
            $badge('b3', 'Pahlawan B3', 'bi-shield-fill-exclamation', 'Menyetor 3 sampah B3', $b3 >= 3, $b3, 3),
            $badge('serbabisa', 'Serba Bisa', 'bi-stars', 'Menyetor keempat jenis sampah', $jenisUnik->count() >= 4, $jenisUnik->count(), 4),
            $badge('konsisten', 'Konsisten', 'bi-calendar-check-fill', 'Menyetor pada 5 hari berbeda', $hariUnik >= 5, $hariUnik, 5),
            $badge('juara', 'Sang Juara', 'bi-trophy-fill', 'Menjadi peringkat #1 leaderboard', $rank === 1, null, null),
        ];

        // ---- Misi mingguan (Senin s.d. sekarang) ----
        $awalMinggu = Carbon::now()->startOfWeek();
        $mingguIni = $user->setoran()->where('created_at', '>=', $awalMinggu)->get();
        $setoranMinggu = $mingguIni->count();
        $poinMinggu = (int) $mingguIni->sum('poin');
        $b3Minggu = $mingguIni->where('jenis_sampah', 'B3')->count();

        $misiItem = fn ($nama, $ikon, $now, $target) => [
            'nama' => $nama, 'ikon' => $ikon, 'now' => min($now, $target), 'target' => $target,
            'done' => $now >= $target, 'persen' => (int) min(100, round($now / $target * 100)),
        ];
        $misi = [
            $misiItem('Setor 5 sampah minggu ini', 'bi-bag-check-fill', $setoranMinggu, 5),
            $misiItem('Kumpulkan 50 poin minggu ini', 'bi-coin', $poinMinggu, 50),
            $misiItem('Setor 1 sampah B3 minggu ini', 'bi-shield-fill-exclamation', $b3Minggu, 1),
        ];

        return [
            'badges' => $badges,
            'misi' => $misi,
            'ringkas' => [
                'earned' => collect($badges)->where('earned', true)->count(),
                'total' => count($badges),
                'rank' => $rank,
                'totalPoin' => $totalPoin,
            ],
        ];
    }
}
