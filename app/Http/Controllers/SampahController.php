<?php

namespace App\Http\Controllers;

use App\Models\Sampah;
use Illuminate\Http\Request;

class SampahController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! auth()->user() || auth()->user()->role !== 'admin') {
                abort(403, 'Hanya admin yang dapat mengelola data sampah.');
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');

        $sampahs = Sampah::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_sampah', 'like', "{$search}%");
            })
            ->when($jenis, function ($query) use ($jenis) {
                $query->where('jenis_sampah', $jenis);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('sampah.index', compact('sampahs') + ['jenisList' => Sampah::JENIS_SAMPAH]);
    }

    public function create()
    {
        return view('sampah.create', ['jenisList' => Sampah::JENIS_SAMPAH]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sampah' => ['required', 'string', 'max:255'],
            'jenis_sampah' => ['required', 'in:'.implode(',', Sampah::JENIS_SAMPAH)],
            'poin' => ['required', 'integer', 'min:0'],
        ]);

        Sampah::create($data);

        return redirect()->route('sampah.index')
            ->with('success', 'Data sampah berhasil ditambahkan.');
    }

    public function edit(Sampah $sampah)
    {
        return view('sampah.edit', compact('sampah') + ['jenisList' => Sampah::JENIS_SAMPAH]);
    }

    public function update(Request $request, Sampah $sampah)
    {
        $data = $request->validate([
            'nama_sampah' => ['required', 'string', 'max:255'],
            'jenis_sampah' => ['required', 'in:'.implode(',', Sampah::JENIS_SAMPAH)],
            'poin' => ['required', 'integer', 'min:0'],
        ]);

        $sampah->update($data);

        return redirect()->route('sampah.index')
            ->with('success', 'Data sampah berhasil diperbarui.');
    }

    public function destroy(Sampah $sampah)
    {
        $sampah->delete();

        return redirect()->route('sampah.index')
            ->with('success', 'Data sampah berhasil dihapus.');
    }
}
