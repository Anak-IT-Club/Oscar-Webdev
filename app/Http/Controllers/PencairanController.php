<?php

namespace App\Http\Controllers;

use App\Models\Pencairan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PencairanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $riwayat = $user->pencairan()->latest()->get();

        return view('tabungan.index', [
            'user' => $user,
            'riwayat' => $riwayat,
            'metodeList' => config('smartsite.metode_pencairan'),
            'kurs' => (int) config('smartsite.poin_to_rupiah', 100),
        ]);
    }

    public function store(Request $request)
    {
        $kurs = (int) config('smartsite.poin_to_rupiah', 100);

        $data = $request->validate([
            'poin' => ['required', 'integer', 'min:50'],
            'metode' => ['required', 'in:'.implode(',', config('smartsite.metode_pencairan'))],
            'tujuan' => ['nullable', 'string', 'max:100'],
        ]);

        $userId = auth()->id();

        $ok = DB::transaction(function () use ($userId, $data, $kurs) {
            $user = User::whereKey($userId)->lockForUpdate()->firstOrFail();

            if ($user->poin < $data['poin']) {
                return false;
            }

            // Tahan poin sejak pengajuan; dikembalikan bila ditolak.
            $user->decrement('poin', $data['poin']);

            Pencairan::create([
                'user_id' => $user->id,
                'poin' => $data['poin'],
                'nominal' => $data['poin'] * $kurs,
                'metode' => $data['metode'],
                'tujuan' => $data['tujuan'] ?? null,
                'status' => 'pending',
            ]);

            return true;
        });

        if (! $ok) {
            return redirect()->route('tabungan.index')
                ->with('error', 'Poin kamu tidak cukup untuk pencairan sebesar itu.');
        }

        return redirect()->route('tabungan.index')
            ->with('success', 'Pengajuan pencairan terkirim dan menunggu persetujuan admin.');
    }

    public function adminIndex(Request $request)
    {
        $this->pastikanAdmin();

        $status = $request->input('status');

        $pencairans = Pencairan::query()
            ->with('user')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pencairan.index', [
            'pencairans' => $pencairans,
            'pending' => Pencairan::where('status', 'pending')->count(),
            'totalDisetujui' => Pencairan::where('status', 'disetujui')->sum('nominal'),
        ]);
    }

    public function approve(Pencairan $pencairan)
    {
        $this->pastikanAdmin();

        if ($pencairan->status === 'pending') {
            $pencairan->update(['status' => 'disetujui']);
        }

        return back()->with('success', 'Pencairan disetujui.');
    }

    public function reject(Request $request, Pencairan $pencairan)
    {
        $this->pastikanAdmin();

        $request->validate(['catatan_admin' => ['nullable', 'string', 'max:255']]);

        if ($pencairan->status === 'pending') {
            DB::transaction(function () use ($pencairan, $request) {
                // Kembalikan poin yang ditahan.
                $user = User::whereKey($pencairan->user_id)->lockForUpdate()->first();
                if ($user) {
                    $user->increment('poin', $pencairan->poin);
                }
                $pencairan->update([
                    'status' => 'ditolak',
                    'catatan_admin' => $request->input('catatan_admin'),
                ]);
            });
        }

        return back()->with('success', 'Pencairan ditolak dan poin dikembalikan ke siswa.');
    }

    private function pastikanAdmin(): void
    {
        if (! auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat mengelola pencairan.');
        }
    }
}
