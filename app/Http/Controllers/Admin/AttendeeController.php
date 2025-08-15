<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\User;
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
        $user = $request->user();

        return Inertia::render('admin/attendees/Index', [
            'attendees' => Attendee::query()
                ->with([
                    'user',
                    'user.registrations',
                    'user.verifications',
                    'user.payments'
                ])
                ->orderBy('name')
                ->get(),
        ]);
    }
}
