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
        $tahuns = Tahun::withCount('bukus')->get();
        foreach ($tahuns as $tahun) {
            if ($tahun->cover_image) {
                $tahun->cover_image_url = Storage::url('public/cover_years/' . $tahun->cover_image);
            }
        }
        return view('admin/tahuns.index', compact('tahuns'));
    }

    public function frontIndex()
    {
        $tahuns = Tahun::all()->map(function($tahun) {
            if ($tahun->cover_image) {
                $tahun->cover_image_url = Storage::url('public/cover_years/' . $tahun->cover_image);
            }
            return $tahun;
        });

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
        $tahunRecord = Tahun::where('tahun', $tahun)->firstOrFail();

        // Get all categories
        $kategoris = Kategori::all();

        // Get books by category for this year
        $booksByCategory = [];
        $teacherBooks = [];
        $osisBooks = [];

        foreach ($kategoris as $kategori) {
            $books = Buku::with('kategori')
                ->where('tahun_id', $tahunRecord->id)
                ->where('kategori_id', $kategori->id)
                ->get();

            if ($kategori->id == 2) { // Teacher books (kategori_id = 2)
                $teacherBooks = $books;
            } elseif ($kategori->id == 5) { // OSIS books (assuming kategori_id = 5)
                $osisBooks = $books;
            } elseif ($books->count() > 0) {
                $booksByCategory[$kategori->id] = [
                    'name' => $kategori->nama,
                    'books' => $books
                ];
            }
        }

        return view('home_book', compact('tahunRecord', 'booksByCategory', 'teacherBooks', 'osisBooks', 'tahun'));
    }

    public function edit(Tahun $tahun)
    {
        $kategoris = Kategori::all();
        if ($tahun->cover_image) {
            $tahun->cover_image_url = Storage::url('public/cover_years/' . $tahun->cover_image);
        }
        return view('admin/tahuns.edit', compact('tahun', 'kategoris'));
    }

    public function update(Request $request, Tahun $tahun)
    {
        $request->validate([
            'tahun' => 'required|unique:tahuns,tahun,'.$tahun->id,
            'kategori_id' => 'nullable|exists:kategoris,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'tahun' => $request->tahun,
            'kategori_id' => $request->kategori_id
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
