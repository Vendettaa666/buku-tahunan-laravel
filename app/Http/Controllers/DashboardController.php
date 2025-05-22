<?php

namespace App\Http\Controllers;

use App\Models\Tahun;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $tahuns = Tahun::withCount('bukus')->latest()->get();
    $totalBuku = Buku::count();
    $totalKategori = Kategori::count();
    $totalTahun = Tahun::count();
    $latestBuku = Buku::with('tahun')->latest()->first();

    return view('admin/dashboard', compact(
        'tahuns',
        'totalBuku',
        'totalKategori',
        'totalTahun',
        'latestBuku'
    ));
}
}
