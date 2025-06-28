<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegistrationPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): ?Response
    {
        return null;
    }

    public function viewAny(User $user): ?Response
    {
        if ($user->can('admin') || $user->can('super-admin')) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function view(User $user, Registration $registration): Response
    {
        return $user->registrations()->where('id', $registration->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return Response::allow();
    }

    public function update(User $user, Registration $registration): Response
    {
        return $user->registrations()->where('id', $registration->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Registration $registration): Response
    {
        return Response::deny();
    }

    public function restore(User $user, Registration $registration): Response
    {
        return Response::deny();
    }

    public function forceDelete(User $user, Registration $registration): Response
    {
        return Response::deny();
    }
}
