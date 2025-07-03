<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TahunController extends Controller
{
    public function index()
    {
        $tahuns = Tahun::withCount('bukus')
            ->orderBy('tahun', 'asc')
            ->get();
        return view('admin/tahuns.index', compact('tahuns'));
    }

    public function frontIndex()
    {
        $tahuns = Tahun::orderBy('tahun', 'asc')->get();
        return view('index', compact('tahuns'));
    }

    public function create()
    {
        return view('admin/tahuns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|unique:tahuns|max:9',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = [
                'tahun' => $request->tahun,
            ];

            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('cover_years', $filename, 'public');
                $data['cover_image'] = $filename;
            }

            Tahun::create($data);

            return redirect()->route('tahuns.index')
                ->with('success', 'Tahun berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan tahun: ' . $e->getMessage());
        }
    }

    public function show($tahun)
    {
        // Find the year record
        $tahunRecord = Tahun::where('tahun', $tahun)->first();

        // Jika tidak ditemukan, coba cari berdasarkan ID (fallback)
        if (!$tahunRecord) {
            $tahunRecord = Tahun::find($tahun);
        }

        // Jika masih tidak ditemukan, return 404
        if (!$tahunRecord) {
            abort(404, 'Tahun tidak ditemukan');
        }

        // Get all books for this year with their categories
        $books = Buku::with('kategori')
            ->where('tahun_id', $tahunRecord->id)
            ->get();

        // Initialize booksByCategory array
        $booksByCategory = [];

        // Group books by category
        foreach ($books as $book) {
            $categoryId = $book->kategori_id ?? 0; // Default to 0 if no category

            // Handle case when category_id is null
            if ($categoryId === null) {
                $categoryId = 0;
                $categoryName = 'Tidak Berkategori';
            } else {
                // Jika kategori ada, gunakan nama kategori tersebut
                $categoryName = $book->kategori ? $book->kategori->nama : 'Tidak Berkategori';
            }

            // Jika kategori belum ada di array, tambahkan
            if (!isset($booksByCategory[$categoryId])) {
                $booksByCategory[$categoryId] = [
                    'name' => $categoryName,
                    'books' => []
                ];
            }

            // Tambahkan buku ke kategori yang sesuai
            $booksByCategory[$categoryId]['books'][] = $book;
        }

        // Debugging: Log the booksByCategory array to see its structure
        \Illuminate\Support\Facades\Log::debug('Books By Category:', [
            'booksByCategory' => $booksByCategory
        ]);

        // Check if the request is coming from admin section
        if (request()->is('tahuns/*')) {
            return view('admin/tahuns.show', [
                'tahun' => $tahunRecord,
                'booksByCategory' => $booksByCategory
            ]);
        }

        // For frontend
        return view('home_book', [
            'tahunRecord' => $tahunRecord,
            'booksByCategory' => $booksByCategory,
            'tahun' => $tahunRecord->tahun
        ]);
    }

    public function edit(Tahun $tahun)
    {
        $kategoris = Kategori::all();
        return view('admin/tahuns.edit', compact('tahun', 'kategoris'));
    }

    public function update(Request $request, Tahun $tahun)
    {
        $request->validate([
            'tahun' => 'required|unique:tahuns,tahun,'.$tahun->id,
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'tahun' => $request->tahun,
        ];

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($tahun->cover_image) {
                Storage::delete('public/cover_years/' . $tahun->cover_image);
            }

            $image = $request->file('cover_image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('cover_years', $filename, 'public');
            $data['cover_image'] = $filename;
        }

        $tahun->update($data);

        return redirect()->route('tahuns.index')
            ->with('success', 'Tahun berhasil diperbarui');
    }

    public function destroy(Tahun $tahun)
    {
        if ($tahun->cover_image) {
            Storage::delete('public/cover_years/' . $tahun->cover_image);
        }

        $tahun->delete();
        return redirect()->route('tahuns.index')
            ->with('success', 'Tahun berhasil dihapus');
    }
}
