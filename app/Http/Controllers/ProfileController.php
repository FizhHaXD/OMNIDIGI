<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\AvatarSanitizerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, AvatarSanitizerService $avatarSanitizer): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle Avatar Upload with Strict Sanitization
        if ($request->hasFile('avatar')) {
            $safeAvatarPath = $avatarSanitizer->sanitizeAndStore(
                $request->file('avatar'),
                $user->avatar
            );
            $user->avatar = $safeAvatarPath;
        } elseif ($request->boolean('remove_avatar')) {
            // User requested to remove existing avatar
            $avatarSanitizer->deleteAvatar($user->avatar);
            $user->avatar = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, AvatarSanitizerService $avatarSanitizer): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete avatar file if exists
        $avatarSanitizer->deleteAvatar($user->avatar);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
