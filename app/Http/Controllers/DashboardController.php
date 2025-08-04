<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $user->load('attendees');
        $registration = $user->registration;
        $payment = $user->payments->first();

        $usersHavingBios = User::whereHas('registrations', fn ($query) => $query->where('bio', "!=", "")->where('show_attendance', true))->get();

        $usersAttending = User::whereHas('verifications')->orderBy('name', 'asc')
            ->with('attendees')
            ->get()
            ->filter(function ($user) {
                return $user->registration->show_attendance;
            });

        return Inertia::render('Dashboard', [
            'registration' => $registration,
            'verified' => $user->verifications()->exists(),
            'eventRegistrationFilled' => false,
            'attendeesFilled' => $user->attendees()->exists(),
            'attendeeCount' => $user->attendees()->count(),
            'payment' => $payment,
            'biosCount' => $usersHavingBios->count(),
            'userSpotlight' => $usersHavingBios->random(),
            'usersAttending' => $usersAttending,
        ]);
    }
}
