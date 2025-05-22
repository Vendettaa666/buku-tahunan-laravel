<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\FotoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Frontend Routes
Route::get('/', [TahunController::class, 'frontIndex'])->name('home');
Route::get('/years/{tahun}', [TahunController::class, 'show'])->name('years.show');

// Book detail and download routes
Route::get('/buku/{id}/detail/{year}', [BukuController::class, 'detail'])->name('buku.detail');
Route::get('/buku/{id}/download/{year}', [BukuController::class, 'download'])->name('buku.download');

// Admin Dashboard Routes
Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Protected Admin Routes
Route::middleware(['auth'])->group(function () {
    // Tahun Routes
    Route::resource('tahuns', TahunController::class);

    // Buku Routes
    Route::resource('bukus', BukuController::class);

    // Foto Routes
    Route::resource('fotos', FotoController::class);

    // Kategori Routes
    Route::resource('kategoris', KategoriController::class);

    // Logout Route
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

require __DIR__ . '/auth.php';
