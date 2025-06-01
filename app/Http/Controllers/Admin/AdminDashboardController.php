<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            'usersAwaitingVerificationCount' => User::whereHas('registrations')->count(),
        ]);
    }
}
