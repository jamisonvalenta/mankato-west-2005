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

class PublicController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Public', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
        ]);
    }
}
