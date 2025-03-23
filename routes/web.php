<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])
    ->name('home');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
            ->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
