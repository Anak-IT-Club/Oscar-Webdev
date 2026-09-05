<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Sampah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $totalUsers = User::count();
            $totalSiswa = User::where('role', 'siswa')->count();
            $totalPoin = User::sum('poin');

            $poinRaw = Setoran::where('status', 'disetujui')
                ->selectRaw('jenis_sampah, SUM(poin) as total')
                ->groupBy('jenis_sampah')
                ->pluck('total', 'jenis_sampah');

            $jenisLabels = Sampah::JENIS_SAMPAH;
            $jenisData = array_map(fn ($j) => (int) ($poinRaw[$j] ?? 0), $jenisLabels);

            $trenLabels = [];
            $trenData = [];
            foreach (range(6, 0) as $i) {
                $day = Carbon::today()->subDays($i);
                $trenLabels[] = $day->translatedFormat('d M');
                $trenData[] = (int) Setoran::where('status', 'disetujui')->whereDate('created_at', $day)->sum('poin');
            }

            return view('home', compact(
                'totalUsers', 'totalSiswa', 'totalPoin',
                'jenisLabels', 'jenisData', 'trenLabels', 'trenData'
            ));
        }

        return view('home');
    }
}
