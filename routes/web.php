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

Route::view('/', 'welcome');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::middleware(['auth'])->group(function () {
    // ... rute lainnya

    // Tahun Routes
    Route::resource('tahuns', TahunController::class);

    // Buku Routes
    Route::resource('bukus', BukuController::class);

    // Foto Routes
    Route::resource('fotos', FotoController::class);

    Route::resource('kategoris', KategoriController::class);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
});
require __DIR__ . '/auth.php';
