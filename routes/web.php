<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Umum\UmumController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});




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

require __DIR__ . '/auth.php';
