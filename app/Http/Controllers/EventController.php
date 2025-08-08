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

class EventController extends Controller
{
    public function show(Request $request): Response
    {
        $user = $request->user();
        $user->load('attendees');
        $registration = $user->registration;

        $usersAttending = User::whereHas('attendees')->orderBy('name', 'asc')
            ->with('attendees')
            ->withCount('attendees')
            ->get();

        $attendeeCount = $usersAttending->sum(fn ($user) => $user->attendees_count);

        $usersAttendingVisible = $usersAttending->filter(function ($user) {
                return $user->registration->show_attendance;
            });

        $attendeeInvisibleCount = $attendeeCount - $usersAttendingVisible->sum(fn ($user) => $user->attendees_count);

        return Inertia::render('event/ShowEvent', [
            'attendeeCount' => $attendeeCount,
            'usersAttendingVisible' => $usersAttendingVisible,
            'attendeeInvisibleCount' => $attendeeInvisibleCount,
        ]);
    }
}
