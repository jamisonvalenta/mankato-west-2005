<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\MediaUpdateRequest;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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


    public function update(MediaUpdateRequest $request, Media $media): RedirectResponse
    {
        $media->update($request->validated());

        return redirect()->back()
            ->with('success', "Description saved");
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
