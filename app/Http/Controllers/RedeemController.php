<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use App\Models\TukarPoin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedeemController extends Controller
{
    public function index()
    {
        $hadiahs = Hadiah::latest()->get();
        $user = auth()->user();
        $riwayat = $user->tukarPoin()->with('hadiah')->latest()->get();

        return view('redeem.index', compact('hadiahs', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hadiah_id' => ['required', 'exists:hadiah,id'],
        ]);

        $hadiah = Hadiah::findOrFail($request->hadiah_id);
        $userId = auth()->id();

        $cukup = DB::transaction(function () use ($userId, $hadiah) {
            // Kunci baris user agar poin tidak bisa dipakai dua kali secara bersamaan.
            $user = User::whereKey($userId)->lockForUpdate()->firstOrFail();

            if ($user->poin < $hadiah->poin) {
                return false;
            }

            $user->decrement('poin', $hadiah->poin);

            TukarPoin::create([
                'user_id' => $user->id,
                'hadiah_id' => $hadiah->id,
                'poin_dipakai' => $hadiah->poin,
            ]);

            return true;
        });

        if (! $cukup) {
            return redirect()->route('redeem.index')
                ->with('error', 'Poin kamu tidak cukup untuk menukar hadiah ini.');
        }

        return redirect()->route('redeem.index')
            ->with('success', 'Berhasil menukar hadiah '.$hadiah->nama_hadiah.'.');
    }
}
