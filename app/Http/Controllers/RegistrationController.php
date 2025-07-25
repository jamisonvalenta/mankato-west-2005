<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\RegistrationStoreRequest;
use App\Models\Registration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class RegistrationController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('registration/CreateRegistration');
    }

    public function store(RegistrationStoreRequest $request): RedirectResponse
    {
        $request->user()->registrations()->save(new Registration($request->validated()));

        return to_route('dashboard')
            ->with('success', "Registration saved!  If you haven't been approved yet, please wait for an admin to approve you.");
    }

    public function edit(Registration $registration): Response
    {
        $registration = auth()->user()->registrations()->mostRecent()->first();

        return Inertia::render('registration/EditRegistration', [
            'registration' => $registration,
        ]);
    }
}
