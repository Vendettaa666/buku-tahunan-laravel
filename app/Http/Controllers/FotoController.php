<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function index()
    {
        $fotos = Foto::with('buku')->get();
        return view('admin/fotos.index', compact('fotos'));
    }

    public function create()
    {
        $bukus = Buku::all();
        return view('admin/fotos.create', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $path = $request->file('foto')->store('fotos', 'public');

        Foto::create([
            'buku_id' => $request->buku_id,
            'judul' => $request->judul,
            'foto_path' => $path,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('fotos.index')
            ->with('success', 'Foto berhasil ditambahkan');
    }

    public function show(Foto $foto)
    {
        return view('admin/fotos.show', compact('foto'));
    }

    public function edit(Foto $foto)
    {
        $bukus = Buku::all();
        return view('admin/fotos.edit', compact('foto', 'bukus'));
    }

    public function update(Request $request, Foto $foto)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($foto->foto_path) {
                Storage::disk('public')->delete($foto->foto_path);
            }

            $path = $request->file('foto')->store('fotos', 'public');
            $data['foto_path'] = $path;
        }

        $foto->update($data);

        return redirect()->route('fotos.index')
            ->with('success', 'Foto berhasil diperbarui');
    }

    public function destroy(Foto $foto)
    {
        if ($foto->foto_path) {
            Storage::disk('public')->delete($foto->foto_path);
        }

        $foto->delete();

        return redirect()->route('fotos.index')
            ->with('success', 'Foto berhasil dihapus');
    }
}
