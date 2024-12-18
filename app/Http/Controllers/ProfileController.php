<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update only the 'name' field
        $user->name = $request->input('name');
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        // Delete old avatar if it exists
        if ($user->uploaded_avatar) {
            Storage::disk('public')->delete($user->uploaded_avatar);
        }

        // Save new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->uploaded_avatar = $path;
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Avatar updated successfully!');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Delete the avatar file if it exists
        if ($user->uploaded_avatar) {
            Storage::disk('public')->delete($user->uploaded_avatar);
            $user->uploaded_avatar = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('success', 'Avatar deleted successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Удаляем аватар, если он есть
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Выходим из всех сессий
        Auth::logout();
        
        // Удаляем пользователя
        $user->delete();

        // Редирект на главную
        return redirect('/');
    }
}
