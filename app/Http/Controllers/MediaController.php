<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\RegistrationStoreRequest;
use App\Models\Media;
use App\Models\Registration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class MediaController extends Controller
{
    public function index(Request $request): Response
    {
        $galleries = collect(Media::GALLERIES)
            ->map(fn ($gallery) => array_merge($gallery, ['images' => $request->user()->media()->where('gallery', $gallery['key'])->get()]))
            ->filter(fn ($gallery) => $gallery['images']->isNotEmpty());

        return Inertia::render('media/Index', [
            'countImages' => $request->user()->media()->count(),
            'galleries' => $galleries,

        ]);
    }

    public function create(): Response
    {
        return Inertia::render('media/CreateMedia', [
            'galleries' => Media::GALLERIES,
        ]);
    }

    public function destroy(Media $media): RedirectResponse
    {
        Storage::disk('public')->delete($media->filename);
        Storage::disk('cloudinary')->delete($media->cloudinary_public_id);

        $media->delete();

        return redirect()->back()
            ->with('success', "Image deleted");
    }
}
