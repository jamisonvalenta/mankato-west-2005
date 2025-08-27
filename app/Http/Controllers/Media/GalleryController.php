<?php

namespace App\Http\Controllers\Media;

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

class GalleryController extends Controller
{
    public function show(Request $request, $gallery): Response
    {
        $galleries = collect(Media::GALLERIES)->keyBy('key');

        if (! $galleries->has($gallery)) {
            return abort(404);
        }

        $gallery = $galleries->get($gallery);

        $media = Media::where('gallery', $gallery['key'])
            ->orderBy('id', 'desc')
            ->with('user')
            ->get();

        return Inertia::render('media/galleries/Show', [
            'gallery' => $gallery,
            'media' => $media,
        ]);
    }
}
