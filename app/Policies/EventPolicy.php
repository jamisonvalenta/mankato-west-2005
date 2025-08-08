<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): ?Response
    {
        if ($user->can('admin') || $user->can('super-admin')) {
            return Response::allow();
        }

        return null;
    }

    public function viewAny(User $user): Response
    {
        if ($user->verifications()->exists()) {
            return Response::allow();
        }

        return Response::deny();
    }
}
