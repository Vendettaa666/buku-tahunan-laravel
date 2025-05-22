<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BukuController extends Controller
{
   public function index()
{
    $bukus = Buku::with(['tahun', 'kategori'])->latest()->get();
    return view('admin/bukus.index', compact('bukus'));
}
   public function create()
{
    $tahuns = Tahun::all();
    $kategoris = Kategori::all();
    return view('admin/bukus.create', compact('tahuns', 'kategoris'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'tahun_id' => 'required|exists:tahuns,id',
        'kategori_id' => 'required|exists:kategoris,id', // Ensure this is validated
        'nama_kelas' => 'required|string|max:100',
        'penerbit' => 'required|string|max:100',
        'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
    ]);

    // Store the cover and file
    $coverPath = $request->file('cover')->store('covers', 'public');
    $filePath = $request->file('file')->store('buku_files', 'public');

    // Create the book
    Buku::create([
        'tahun_id' => $validated['tahun_id'],
        'kategori_id' => $validated['kategori_id'], // Ensure this is set
        'nama_kelas' => $validated['nama_kelas'],
        'penerbit' => $validated['penerbit'],
        'cover_path' => $coverPath,
        'file_path' => $filePath,
    ]);

    return redirect()->route('bukus.index')
        ->with('success', 'Buku tahunan berhasil ditambahkan!');
}

    public function show(Buku $buku)
{
    $buku->load('tahun', 'kategori'); // Memuat relasi tahun dan kategori
    return view('admin/bukus.show', compact('buku'));
}

    // Method untuk menampilkan detail buku di frontend
    public function detail($id, $year)
    {
        // Find the year record
        $tahunRecord = Tahun::where('tahun', $year)->firstOrFail();

        // Find the book
        $buku = Buku::with(['tahun', 'kategori'])
            ->where('id', $id)
            ->where('tahun_id', $tahunRecord->id)
            ->firstOrFail();

        // Check if this is a teacher book
        $isTeacherBook = ($buku->kategori_id == 2);

        return view('detail_book', compact('buku', 'year', 'isTeacherBook'));
    }

    // Method untuk download file
    public function download($id, $year)
    {
        // Find the year record
        $tahunRecord = Tahun::where('tahun', $year)->firstOrFail();

        // Find the book
        $buku = Buku::where('id', $id)
            ->where('tahun_id', $tahunRecord->id)
            ->firstOrFail();

        if (!$buku->file_path) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = storage_path('app/public/' . $buku->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath, basename($buku->file_path));
    }

    public function edit(Buku $buku)
{
    $tahuns = Tahun::all();
    $kategoris = Kategori::all();
    return view('admin/bukus.edit', compact('buku', 'tahuns', 'kategoris'));
}

    public function update(Request $request, Buku $buku)
{
    $request->validate([
        'tahun_id' => 'required|exists:tahuns,id',
        'kategori_id' => 'required|exists:kategoris,id',
        'nama_kelas' => 'required|string|max:100',
        'penerbit' => 'required|string|max:100',
        'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only(['tahun_id', 'kategori_id', 'nama_kelas', 'penerbit']);

    if ($request->hasFile('cover')) {
        // Hapus cover lama jika ada
        if ($buku->cover_path) {
            Storage::disk('public')->delete($buku->cover_path);
        }
        $data['cover_path'] = $request->file('cover')->store('covers', 'public');
    } elseif ($request->has('remove_cover')) {
        // Hapus cover jika dicentang
        if ($buku->cover_path) {
            Storage::disk('public')->delete($buku->cover_path);
        }
        $data['cover_path'] = null;
    }

    $buku->update($data);

    return redirect()->route('bukus.show', $buku->id)
        ->with('success', 'Buku berhasil diperbarui');
}

   public function destroy(Buku $buku)
{
    // Hapus file dari storage
    Storage::disk('public')->delete([$buku->cover_path, $buku->file_path]);

    // Hapus record dari database
    $buku->delete();

    return redirect()->route('bukus.index')
        ->with('success', 'Buku berhasil dihapus');
}
}
