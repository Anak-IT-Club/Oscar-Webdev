<?php

namespace App\Http\Controllers;

use App\Models\Hadiah;
use Illuminate\Http\Request;

class HadiahController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! auth()->user() || auth()->user()->role !== 'admin') {
                abort(403, 'Hanya admin yang dapat mengelola hadiah.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $poin = $request->input('poin');

        $hadiahs = Hadiah::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_hadiah', 'like', "{$search}%");
            })
            ->when($poin, function ($query) use ($poin) {
                if ($poin === 'low') {
                    $query->where('poin', '<=', 25);
                } elseif ($poin === 'mid') {
                    $query->whereBetween('poin', [26, 50]);
                } elseif ($poin === 'high') {
                    $query->where('poin', '>', 50);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('hadiah.index', compact('hadiahs'));
    }

    public function create()
    {
        return view('hadiah.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_hadiah' => ['required', 'string', 'max:255'],
            'poin' => ['required', 'integer', 'min:0'],
        ]);

        Hadiah::create($data);

        return redirect()->route('hadiah.index')
            ->with('success', 'Hadiah berhasil ditambahkan.');
    }

    public function edit(Hadiah $hadiah)
    {
        return view('hadiah.edit', compact('hadiah'));
    }

    public function update(Request $request, Hadiah $hadiah)
    {
        $data = $request->validate([
            'nama_hadiah' => ['required', 'string', 'max:255'],
            'poin' => ['required', 'integer', 'min:0'],
        ]);

        $hadiah->update($data);

        return redirect()->route('hadiah.index')
            ->with('success', 'Hadiah berhasil diperbarui.');
    }

    public function destroy(Hadiah $hadiah)
    {
        $hadiah->delete();

        return redirect()->route('hadiah.index')
            ->with('success', 'Hadiah berhasil dihapus.');
    }
}
