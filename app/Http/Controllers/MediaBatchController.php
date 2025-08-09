<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\RegistrationStoreRequest;
use App\Models\Registration;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class MediaBatchController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        collect($request->file('files'))
            ->map(function (UploadedFile $uploadedFile) {
                return [
                    'local' => $uploadedFile->store('', 'public'),
                    'cloudinary' => $uploadedFile->store('mankato-west', 'cloudinary'),
                ];
            })
            ->each(function ($filenames) use ($request) {
                $request->user()->media()->create([
                    'type' => 'image',
                    'cloudinary_public_id' => $filenames['cloudinary'],
                    'filename' => $filenames['local'],
                    'gallery' => $request->input('gallery', 'archive'),
                ]);
            });

        return response()->json(['status'=>'success', 'message'=>"Media saved! You can upload more as you find them"], 200);
    }
}
