<?php

use App\Models\Attendee;
use App\Models\Event;
use App\Models\Media;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Verification;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])
    ->name('home');


Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('events/twenty-year', [App\Http\Controllers\EventController::class, 'show'])
            ->name('events.twenty-year')
            ->can('viewAny', Event::class);

        Route::get('privacy', [App\Http\Controllers\PrivacyController::class, 'index'])
            ->name('privacy');

        Route::get('registration/create', [App\Http\Controllers\RegistrationController::class, 'create'])
            ->name('registration.create')
            ->can('create', Registration::class);
        Route::post('registration', [App\Http\Controllers\RegistrationController::class, 'store'])
            ->name('registration.store')
            ->can('create', Registration::class);
        Route::get('registration/{registration}/edit', [App\Http\Controllers\RegistrationController::class, 'edit'])
            ->name('registration.edit')
            ->can('update', 'registration')
            ;

        Route::get('attendee', [App\Http\Controllers\AttendeeController::class, 'index'])
            ->name('attendee.index');
        Route::get('attendee/create', [App\Http\Controllers\AttendeeController::class, 'create'])
            ->name('attendee.create')
            ->can('create', Attendee::class);

        Route::post('attendee', [App\Http\Controllers\AttendeeController::class, 'store'])
            ->name('attendee.store')
            ->can('create', Attendee::class);

        Route::get('attendee/{attendee}/edit', [App\Http\Controllers\AttendeeController::class, 'edit'])
            ->name('attendee.edit')
            ->can('update', 'attendee');
        Route::post('attendee/{attendee}', [App\Http\Controllers\AttendeeController::class, 'update'])
            ->name('attendee.update')
            ->can('update', 'attendee');

        Route::delete('attendee/{attendee}', [App\Http\Controllers\AttendeeController::class, 'destroy'])
            ->name('attendee.destroy')
            ->can('delete', 'attendee');

        Route::get('media', [App\Http\Controllers\MediaController::class, 'index'])
            ->name('media.index')
            ->can('viewAny', Media::class);
        Route::get('media/create', [App\Http\Controllers\MediaController::class, 'create'])
            ->name('media.create')
            ->can('create', Media::class);

        Route::delete('media/{media}', [App\Http\Controllers\MediaController::class, 'destroy'])
            ->name('media.destroy')
            ->can('delete', 'media');

        Route::post('media-batch', [App\Http\Controllers\MediaBatchController::class, 'store'])
            ->name('media-batch.store')
            ->can('create', Media::class);

        Route::get('media/galleries/{gallery}', [App\Http\Controllers\Media\GalleryController::class, 'show'])
            ->name('media.galleries.show');

        Route::get('payments', [App\Http\Controllers\PaymentController::class, 'index'])
            ->name('payments.index')
            ->can('viewAny', Payment::class);
        Route::get('payments/create', [App\Http\Controllers\PaymentController::class, 'create'])
            ->name('payments.create')
            ->can('create', Payment::class);
        Route::post('payments', [App\Http\Controllers\PaymentController::class, 'store'])
            ->name('payments.store')
            ->can('create', Payment::class);

        Route::post('payments/{payment}', [App\Http\Controllers\PaymentController::class, 'update'])
            ->name('payments.update')
            ->can('update', 'payment');

        Route::delete('payments/{payment}', [App\Http\Controllers\PaymentController::class, 'destroy'])
            ->name('payments.destroy')
            ->can('delete', 'payment');

});

Route::middleware([
        'auth',
        'verified',
        'can:admin',
    ])
    ->name('admin.')
    ->prefix('admin/')
    ->group(function () {
        Route::get('attendees', [App\Http\Controllers\Admin\AttendeeController::class, 'index'])
            ->name('attendees.index');

        Route::get('dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('users.index');

        Route::get('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])
            ->name('users.show');

        Route::post('verifications', [App\Http\Controllers\Admin\VerificationController::class, 'store'])
            ->name('verifications.store')
            ->can('create', Verification::class);


        Route::post('payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'update'])
            ->name('payments.update')
            ->can('update', 'payment');

        Route::post('payments', [App\Http\Controllers\Admin\PaymentController::class, 'store'])
            ->name('payments.store')
            ->can('create', App\Models\Payment::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
