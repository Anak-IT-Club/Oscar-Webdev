<?php

namespace App\Http\Controllers;

class RiwayatController extends Controller
{
    /**
     * Riwayat setoran (klaim sampah) milik siswa yang sedang login.
     */
    public function index()
    {
        $user = auth()->user();

        $setorans = $user->setoran()->with('sampah')->latest()->paginate(12);

        return view('riwayat.index', [
            'setorans' => $setorans,
            'totalDisetujui' => $user->setoran()->where('status', 'disetujui')->count(),
            'poinDidapat' => (int) $user->setoran()->where('status', 'disetujui')->sum('poin'),
            'menunggu' => $user->setoran()->where('status', 'pending')->count(),
        ]);
    }
}
