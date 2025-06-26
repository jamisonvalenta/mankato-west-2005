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


        Route::get('attendee', [App\Http\Controllers\AttendeeController::class, 'index'])
            ->name('attendee.index');
        Route::get('attendee/create', [App\Http\Controllers\AttendeeController::class, 'create'])
            ->name('attendee.create');
        Route::post('attendee', [App\Http\Controllers\AttendeeController::class, 'store'])
            ->name('attendee.store');

        Route::get('attendee/{attendee}/edit', [App\Http\Controllers\AttendeeController::class, 'edit'])
            ->name('attendee.edit');
        Route::post('attendee/{attendee}', [App\Http\Controllers\AttendeeController::class, 'update'])
            ->name('attendee.update');

        Route::delete('attendee/{attendee}', [App\Http\Controllers\AttendeeController::class, 'destroy'])
            ->name('attendee.destroy');
});

Route::middleware(['auth', 'verified', 'can:admin'])
    ->name('admin.')
    ->prefix('admin/')
    ->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('users.index');

        Route::post('verifications', [App\Http\Controllers\Admin\VerificationController::class, 'store'])
            ->name('verifications.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
