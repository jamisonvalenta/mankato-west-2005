<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $registration = $user->registration;
        $payment = $registration->payments()->exists() ? $registration->payments->first() : null;

        return Inertia::render('Dashboard', [
            'registrationFilled' => $registration !== null,
            'verified' => $user->verifications()->exists(),
            'eventRegistrationFilled' => false,
            'attendeesFilled' => $user->attendees()->exists(),
            'attendeeCount' => $user->attendees()->count(),
            'payment' => $payment,
        ]);
    }
}
