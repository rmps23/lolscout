<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Nation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (config('app.showcase')) {
            return $this->closed();
        }

        return view('auth.register', [
            'nations' => Nation::orderBy('name')->get(),
            'roles' => Role::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (config('app.showcase')) {
            return $this->closed();
        }

        $data = $request->validate([
            'username' => ['required', 'string', 'max:30', 'regex:/^[A-Za-z0-9_-]+$/', 'unique:users,username', Rule::notIn(['admin', 'administrator'])],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'nation_id' => ['required', 'exists:nations,id'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user = User::create($data);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    private function closed(): RedirectResponse
    {
        return redirect()->route('login')->with('status', 'Sign-ups are disabled in this demo. Use the demo login instead.');
    }
}
