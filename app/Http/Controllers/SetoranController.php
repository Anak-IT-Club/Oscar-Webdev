<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use App\Models\Setoran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetoranController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! auth()->user() || auth()->user()->role !== 'admin') {
                abort(403, 'Hanya admin yang dapat mengelola setoran sampah.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');

        $setorans = Setoran::query()
            ->with(['user', 'sampah'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'like', "{$search}%")
                        ->orWhere('nisn', 'like', "{$search}%");
                });
            })
            ->when($jenis, fn ($query) => $query->where('jenis_sampah', $jenis))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('setoran.index', [
            'setorans' => $setorans,
            'jenisList' => Sampah::JENIS_SAMPAH,
            'totalPoinHariIni' => Setoran::where('status', 'disetujui')->whereDate('created_at', today())->sum('poin'),
            'totalPoinSemua' => Setoran::where('status', 'disetujui')->sum('poin'),
            'pendingCount' => Setoran::where('status', 'pending')->count(),
        ]);
    }

    public function create()
    {
        return view('setoran.create', [
            'siswaList' => User::where('role', 'siswa')->orderBy('nama')->get(),
            'sampahList' => Sampah::orderBy('nama_sampah')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'sampah_id' => ['required', 'exists:sampah,id'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);

        $sampah = Sampah::findOrFail($data['sampah_id']);

        DB::transaction(function () use ($data, $sampah) {
            $user = User::whereKey($data['user_id'])->lockForUpdate()->firstOrFail();

            Setoran::create([
                'user_id' => $user->id,
                'sampah_id' => $sampah->id,
                'jenis_sampah' => $sampah->jenis_sampah,
                'poin' => $sampah->poin,
                'sumber' => 'manual',
                'status' => 'disetujui',
                'catatan' => $data['catatan'] ?? null,
            ]);

            $user->increment('poin', $sampah->poin);
        });

        return redirect()->route('setoran.index')
            ->with('success', 'Setoran sampah berhasil dicatat dan poin siswa ditambahkan.');
    }

    public function validasi()
    {
        $pendings = Setoran::with(['user', 'sampah'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(12);

        return view('setoran.validasi', [
            'pendings' => $pendings,
            'pendingCount' => Setoran::where('status', 'pending')->count(),
        ]);
    }

    public function approve(Setoran $setoran)
    {
        if ($setoran->status === 'pending') {
            DB::transaction(function () use ($setoran) {
                $user = User::whereKey($setoran->user_id)->lockForUpdate()->first();
                if ($user) {
                    $user->increment('poin', $setoran->poin);
                }
                $setoran->update(['status' => 'disetujui']);
            });
        }

        return back()->with('success', 'Setoran divalidasi — poin ditambahkan ke siswa.');
    }

    public function reject(Setoran $setoran)
    {
        if ($setoran->status === 'pending') {
            $setoran->update(['status' => 'ditolak']);
        }

        return back()->with('success', 'Setoran ditolak. Poin tidak ditambahkan.');
    }

    public function destroy(Setoran $setoran)
    {
        DB::transaction(function () use ($setoran) {
            if ($setoran->status === 'disetujui') {
                $user = User::whereKey($setoran->user_id)->lockForUpdate()->first();
                if ($user) {
                    $user->update(['poin' => max(0, $user->poin - $setoran->poin)]);
                }
            }

            if ($setoran->foto && file_exists(public_path('foto_setoran/'.$setoran->foto))) {
                @unlink(public_path('foto_setoran/'.$setoran->foto));
            }

            $setoran->delete();
        });

        return redirect()->route('setoran.index')
            ->with('success', 'Setoran dihapus dan poin siswa disesuaikan.');
    }
}
