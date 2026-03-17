<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileAvatarController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar_file' => ['nullable', 'image', 'max:5120'], // 5MB Max
            'selected_avatar' => ['nullable', 'string'],
        ]);

        $user = $request->user();

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            
            // Generate filename
            $filename = 'avatars/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Create ImageManager with desired driver
            $manager = new ImageManager(new Driver());

            // Read image from file
            $image = $manager->read($file->getRealPath());

            // Crop image to a square shape (e.g. 500x500)
            $image->cover(500, 500);

            // Encode to original format or force say webp
            $encoded = $image->toWebp(90);

            $filenameWebp = 'avatars/' . $user->id . '_' . time() . '.webp';

            // Save to public storage
            Storage::disk('public')->put($filenameWebp, (string) $encoded);

            // Update user
            $user->avatar = $filenameWebp;
        } elseif ($request->filled('selected_avatar')) {
            // Update user to chosen predefined avatar
            $user->avatar = $request->input('selected_avatar');
        }

        if ($user->isDirty('avatar')) {
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }
}
