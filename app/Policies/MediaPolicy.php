<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MediaPolicy
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

    public function viewAny(User $user): ?Response
    {
        return Response::allow();
    }

    public function view(User $user, Media $media): Response
    {
        return Response::deny();
    }

    public function create(User $user): Response
    {
        if ($user->verifications()->exists()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function update(User $user, Media $media): Response
    {
        return Response::deny();
    }

    public function delete(User $user, Media $media): Response
    {
        if ($user->media()->where('id', $media->id)->exists()) {
            return Response::allow();
        }

        return Response::deny();
    }

    public function restore(User $user, Media $media): Response
    {
        return Response::deny();
    }

    public function forceDelete(User $user, Media $media): Response
    {
        return Response::deny();
    }
}
