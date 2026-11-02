<?php

namespace App\Http\Controllers;

use App\Models\Nation;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(Request $request): View
    {
        return view('settings.account', [
            'user' => $request->user(),
            'roles' => Role::orderBy('id')->get(),
            'nations' => Nation::orderBy('name')->get(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'username' => ['required', 'string', 'max:30', 'regex:/^[A-Za-z0-9_-]+$/', Rule::unique('users', 'username')->ignore($user->id), Rule::notIn(['admin', 'administrator'])],
            'role_id' => ['required', 'exists:roles,id'],
            'nation_id' => ['required', 'exists:nations,id'],
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($data);

        return back()->with('status', 'Profile updated.');
    }

    public function updateEmail(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'current_password' => ['required', 'current_password'],
        ]);

        if ($data['email'] !== $user->email) {
            $user->forceFill(['email' => $data['email'], 'email_verified_at' => null])->save();
            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.notice')->with('status', 'Check your new address to verify it.');
        }

        return back();
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update(['password' => $data['password']]);

        return back()->with('status', 'Password changed.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['delete_password' => ['required', 'current_password']]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Your account has been deleted.');
    }
}
