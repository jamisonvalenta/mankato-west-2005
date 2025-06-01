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

class VerificationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/verifications/Index');
    }

    public function store(RegistrationStoreRequest $request): RedirectResponse
    {
        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->registrations()->save(new Registration($request->validated()));

        // return to_route('registration.edit');
    }

    public function edit(): Response
    {
        // $registration = auth()->user()->registrations()->mostRecent()->first();

        // return Inertia::render('registration/EditRegistration', [
        //     'registration' => $registration,
        // ]);
    }
}
