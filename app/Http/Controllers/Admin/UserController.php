<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('admin/users/Index', [
            'users' => User::query()
                ->when($request->input('filter') === 'unregistered', function ($query) {
                    $query->whereDoesntHave('registrations');
                })
                ->when($request->input('filter') === 'registered', function ($query) {
                    $query->whereHas('registrations');
                })
                ->when($request->input('filter') === 'unverified', function ($query) {
                    $query->whereDoesntHave('verifications')
                        ->whereHas('registrations');
                })
                ->when($request->input('filter') === 'verifiednotattending', function ($query) {
                    $query->whereHas('verifications')
                        ->whereDoesntHave('attendees');
                })
                ->when($request->input('filter') === 'verified', function ($query) {
                    $query->whereHas('verifications');
                })
                ->when($request->input('filter') === 'attendeesfilled', function ($query) {
                    $query->whereHas('attendees');
                })
                ->when($request->input('filter') === 'awaitingpayment', function ($query) {
                    $query->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereHas('attendees')
                                ->whereHas('payments', function ($query) {
                                    $query->whereNull('received_at');
                                });
                        })->orWhere(function ($query) {
                            $query->whereHas('attendees')
                                ->whereDoesntHave('payments');
                        });
                    })->orWhereHas('payments', function ($query) {
                        $query->whereNull('received_at');
                    });
                })
                ->when($request->input('filter') === 'complete', function ($query) {
                    $query->where(function ($query) {
                        $query->whereHas('payments', function ($query) {
                            $query->whereNotNull('received_at');
                        });
                    });
                })
                ->with(['roles', 'verifications', 'attendees', 'payments'])
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(Request $request, User $user): Response
    {
        $user->load(['verifications', 'payments','media', 'attendees']);

        return Inertia::render('admin/users/Show')
            ->with('user', $user);
    }

}
