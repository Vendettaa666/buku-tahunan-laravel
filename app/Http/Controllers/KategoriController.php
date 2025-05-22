<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin/kategoris.index', compact('kategoris'));
    }

    public function create()
{
    return view('admin/kategoris.create'); // Tanpa passing variabel
}

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kategoris|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategori $kategori)
{
    return view('admin/kategoris.edit', compact('kategori')); // Dengan variabel $kategori
}

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama' => 'required|max:100|unique:kategoris,nama,'.$kategori->id,
            'deskripsi' => 'nullable|string'
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kategoris.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
