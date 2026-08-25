<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::latest()->get();

        return view('nasabah.index', compact('nasabahs'));
    }

    public function create()
    {
        return view('nasabah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:nasabahs,nis',
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $validated['saldo'] = 0;

        Nasabah::create($validated);

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function show(Nasabah $nasabah)
    {
        return view('nasabah.show', compact('nasabah'));
    }

    public function edit(Nasabah $nasabah)
    {
        return view('nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:nasabahs,nis,' . $nasabah->id,
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $nasabah->update($validated);

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Nasabah berhasil dihapus.');
    }
}
