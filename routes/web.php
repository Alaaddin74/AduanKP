<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Umum\UmumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Rute untuk pengguna umum tanpa login.
*/

// =======================
// 🏠 Halaman Awal ➝ Redirect ke Dashboard
// =======================
Route::get('/', fn () => redirect()->route('user.dashboard'))->name('home');

// =======================
// 📄 Dashboard Laporan (Tanpa Login)
// =======================
Route::get('/dashboard', [UmumController::class, 'index'])->name('user.dashboard');

// =======================
// 📝 Formulir Laporan Tiket
// =======================
Route::get('/lapor', [UmumController::class, 'create'])->name('lapor.create');
Route::post('/lapor', [UmumController::class, 'store'])->name('lapor.store');

// =======================
// ✏️ Edit & 🗑️ Hapus Tiket (Jika Diizinkan Tanpa Login)
// =======================
Route::get('/ticket/{id}/edit', [UmumController::class, 'edit'])->name('ticket.edit');
Route::put('/ticket/{id}', [UmumController::class, 'update'])->name('ticket.update');
Route::delete('/ticket/{id}', [UmumController::class, 'destroy'])->name('ticket.destroy');
