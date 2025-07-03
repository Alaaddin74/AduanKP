<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\DisplayTicket;
use App\Livewire\Admin\EditTicket;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('TicketTable', function () {
    return view('admin.TicketTable');
})->middleware(['auth', 'verified'])->name('tickets.index');


Route::middleware(['auth'])->group(function () {

    Route::get('/admin/tickets/{ticket}/edit', EditTicket::class)->name('admin.tickets.edit');
    Route::get('/tickets/{ticketId}', DisplayTicket::class)->name('tickets.show');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
