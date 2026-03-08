<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

 Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
 ])->name('home');

 Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
 });

Route::livewire('/features', 'public-list-features')->name('list');
Route::livewire('/features/{feature}', 'public-view-feature')->name('view-feature');

require __DIR__.'/settings.php';
