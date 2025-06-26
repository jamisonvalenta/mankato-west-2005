<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendee\AttendeeStoreRequest;
use App\Http\Requests\Registration\RegistrationStoreRequest;
use App\Models\Attendee;
use App\Models\Registration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class AttendeeController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('attendee/Index')
            ->with('registration', $request->user()->registration)
            ->with('attendees', $request->user()->attendees);
    }

    public function create(Request $request): Response
    {
        $attendee = [
            'id' => null,
            'name' => $request->user()->attendees->isEmpty() ? $request->user()->name : null,
            'nametag' => null,
            'pronouns' => null,
            'accommodation_requests' => null,
            'emergency_contact_name' => null,
            'emergency_contact_phone' => null,
            'emergency_contact_relationship' => null,
        ];

        return Inertia::render('attendee/Edit')
            ->with('registration', $request->user()->registration)
            ->with('attendees', $request->user()->attendees)
            ->with('attendee', $attendee);
    }

    public function store(AttendeeStoreRequest $request): RedirectResponse
    {
        $request->user()->registration->attendees()->save(new Attendee($request->validated()));

        return redirect()->route('attendee.index')
            ->with('success', "Attendee saved");
    }

    public function edit(Request $request, Attendee $attendee): Response
    {
        return Inertia::render('attendee/Edit')
            ->with('registration', $request->user()->registration)
            ->with('attendees', $request->user()->attendees)
            ->with('attendee', $attendee);
    }

    public function update(AttendeeStoreRequest $request, Attendee $attendee): RedirectResponse
    {
        $attendee->update($request->validated());

        return redirect()->route('attendee.index')
            ->with('success', "Attendee saved");
    }

    public function destroy(Attendee $attendee): RedirectResponse
    {
        $attendee->delete();

        return redirect()->route('attendee.index')
            ->with('success', "Attendee deleted");
    }

}
