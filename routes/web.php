<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Umum\UmumController;

// =======================
// 🏠 Halaman Awal ➝ Dashboard
// =======================
Route::get('/', fn() => redirect()->route('dashboard'))->name('home');


// =======================
// 📩 Form Laporan Tiket
// =======================
Route::get('/lapor', [UmumController::class, 'create'])->name('lapor.create');
Route::post('/lapor', [UmumController::class, 'store'])->name('lapor.store');

// =======================
// ✏️ Edit dan Hapus Tiket (jika diizinkan publik)
// =======================
Route::get('/ticket/{id}/edit', [UmumController::class, 'edit'])->name('ticket.edit');
Route::put('/ticket/{id}', [UmumController::class, 'update'])->name('ticket.update');
Route::delete('/ticket/{id}', [UmumController::class, 'destroy'])->name('ticket.destroy');

// Tanpa login
Route::get('/dashboard', [UmumController::class, 'index'])->name('dashboard');
Route::get('/lapor', [UmumController::class, 'create'])->name('lapor.create');
Route::post('/lapor', [UmumController::class, 'store'])->name('lapor.store');

