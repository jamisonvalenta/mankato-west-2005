<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])
    ->name('home');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('registration/create', [App\Http\Controllers\RegistrationController::class, 'create'])
            ->name('registration.create');
        Route::post('registration', [App\Http\Controllers\RegistrationController::class, 'store'])
            ->name('registration.store');
        Route::get('registration/edit', [App\Http\Controllers\RegistrationController::class, 'edit'])
            ->name('registration.edit');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
