<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verification\VerificationStoreRequest;
use App\Models\Registration;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
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

    public function store(VerificationStoreRequest $request): RedirectResponse
    {
        if ($request->input('verify') !== true) {
            return json(['message' => 'There was an issue processing your request'], 422);
        }

        $user = User::find($request->input('user_id'));

        $user->verifications()->save(new Verification([
            'created_by' => $request->user()->id,
        ]));

        // return response()->json(['message' => "User has been verified"]);


        // return to_route('admin.users.index')
        //     ->with('success', "User has been verified");

        return redirect()->back()
            ->with('success', "User has been verified");

        // return Inertia::render('admin/users/Index');

        // return to_route('admin.users.index')
        //     ->with('success', "User has been verified");
    }

    public function edit(): Response
    {
        // $registration = auth()->user()->registrations()->mostRecent()->first();

        // return Inertia::render('registration/EditRegistration', [
        //     'registration' => $registration,
        // ]);
    }
}
