<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(Request $request): Response
    {

        return Inertia::render('admin/Dashboard', [
            'usersCount' => User::count(),
            'usersUnregisteredCount' => User::whereDoesntHave('registrations')->count(),
            'usersAwaitingVerificationCount' => User::whereHas('registrations')->whereDoesntHave('verifications')->count(),
            'usersAwaitingPaymentCount' => User::query()
                ->where(function ($query) {
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
                })->count(),
            'confirmedAttendeesCount' => User::query()
                ->whereHas('attendees')
                ->whereHas('payments', function ($query) {
                    return $query->whereNotNull('received_at');
                })
                ->with('attendees')
                ->get()
                ->reduce(function (?int $carry, $user) {
                    return (int) $carry + $user->attendees->count();
                }),

            'paymentReceivedTotal' => Payment::whereNotNull('received_at')->sum('amount'),
            'paymentPromisedTotal' => Payment::sum('amount'),
        ]);
    }
}
