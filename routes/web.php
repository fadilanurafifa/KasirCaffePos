<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class,'indexPage'])->name('dashboard');

// login
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');

// barang 
Route::get('admin/barang', [BarangController::class, 'index'])->name('barang.index');
Route::post('admin/barang', [BarangController::class, 'store'])->name('barang.store');
Route::delete('admin/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

// kategori
Route::get('admin/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::post('admin/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::delete('admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

// produk
Route::prefix('admin')->group(function () {
    Route::resource('produk', ProdukController::class)->names([
        'index' => 'admin.produk.index',
        'create' => 'admin.produk.create',
        'store' => 'admin.produk.store',
        'edit' => 'admin.produk.edit',
        'update' => 'admin.produk.update',
        'destroy' => 'admin.produk.destroy',
    ]);
});


