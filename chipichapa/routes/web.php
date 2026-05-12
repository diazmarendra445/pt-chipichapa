<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\User\BarangController as UserBarangController;
use App\Http\Controllers\User\FakturController;

// ===================== ROOT =====================
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.barang.index')
            : redirect()->route('user.barang.index');
    }
    return redirect()->route('login');
});

// ===================== AUTH =====================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ===================== ADMIN =====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Barang CRUD
    Route::resource('barang', AdminBarangController::class);

    // Kategori CRUD
    Route::resource('kategori', AdminKategoriController::class)->except(['show']);
});

// ===================== USER =====================
Route::prefix('user')->name('user.')->middleware(['auth', 'user'])->group(function () {

    // Katalog barang
    Route::get('barang', [UserBarangController::class, 'index'])->name('barang.index');
    Route::post('barang/{barang}/keranjang', [UserBarangController::class, 'addToKeranjang'])->name('barang.keranjang');
    Route::patch('keranjang/{barangId}', [UserBarangController::class, 'updateKeranjang'])->name('keranjang.update');
    Route::delete('keranjang/{barangId}', [UserBarangController::class, 'removeFromKeranjang'])->name('keranjang.remove');

    // Faktur
    Route::get('faktur', [FakturController::class, 'index'])->name('faktur.index');
    Route::post('faktur', [FakturController::class, 'store'])->name('faktur.store');
    Route::get('faktur/{faktur}', [FakturController::class, 'show'])->name('faktur.show');
    Route::get('faktur-history', [FakturController::class, 'history'])->name('faktur.history');
});
