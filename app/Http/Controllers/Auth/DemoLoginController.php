<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * One-click login for the public showcase. The visitor never types or sees a password:
 * the server signs the demo user in directly. Outside showcase mode the route is a 404.
 */
class DemoLoginController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        abort_unless(config('app.showcase'), 404);

        $demo = User::where('email', config('app.demo_email'))->first();
        abort_if($demo === null, 404);

        Auth::login($demo);
        $request->session()->regenerate();

        return redirect()->route('settings.account');
    }
}
