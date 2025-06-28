<?php

namespace App\Policies;

use App\Models\Attendee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendeePolicy
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

    public function view(User $user, Attendee $attendee): Response
    {
        return $user->attendees()->where('id', $attendae->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return Response::allow();
    }

    public function update(User $user, Attendee $attendee): Response
    {
        return $user->attendees()->where('id', $attendee->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Attendee $attendee): Response
    {
        return $user->attendees()->where('id', $attendee->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function restore(User $user, Attendee $attendee): Response
    {
        return Response::deny();
    }

    public function forceDelete(User $user, Attendee $attendee): Response
    {
        return Response::deny();
    }
}
