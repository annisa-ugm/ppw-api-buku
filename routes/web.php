<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\GalleryController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku/store', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::resource('gallery', GalleryController::class);
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::get('/buku/{id}/show', [BukuController::class, 'show'])->name('buku.show');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
});

Route::get('/books', function () {
    return view('buku.listbuku');
});

// Rute untuk registrasi dan login
Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/register', [LoginRegisterController::class, 'store'])->name('store');
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');

// Rute dashboard tanpa middleware admin
Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
Route::get('/buku/lihatgambar/{filename}', [BukuController::class, 'lihatgambar'])->name('buku.lihatgambar')->middleware('admin');
