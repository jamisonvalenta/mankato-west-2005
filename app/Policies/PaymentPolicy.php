<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
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
        return Response::allow();
    }

    public function view(User $user, Payment $payment): Response
    {
        return $user->payments()->where('id', $payment->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): Response
    {
        return Response::allow();
    }

    public function update(User $user, Payment $payment): Response
    {
        return $user->payments()->where('id', $payment->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Payment $payment): Response
    {
        return $user->payments()->where('id', $payment->id)->exists()
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
