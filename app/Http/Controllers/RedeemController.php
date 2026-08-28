<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use App\Models\TukarPoin;
use Illuminate\Http\Request;

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
        $user = auth()->user();

        if ($user->poin < $hadiah->poin) {
            return redirect()->route('redeem.index')
                ->with('error', 'Poin kamu tidak cukup untuk menukar hadiah ini.');
        }

        $user->decrement('poin', $hadiah->poin);

        TukarPoin::create([
            'user_id' => $user->id,
            'hadiah_id' => $hadiah->id,
            'poin_dipakai' => $hadiah->poin,
        ]);

        return redirect()->route('redeem.index')
            ->with('success', 'Berhasil menukar hadiah '.$hadiah->nama_hadiah.'.');
    }
}
