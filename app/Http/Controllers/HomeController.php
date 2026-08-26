<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

            return view('home', compact('totalUsers', 'totalSiswa', 'totalPoin'));
        }

        return view('home');
    }
}
