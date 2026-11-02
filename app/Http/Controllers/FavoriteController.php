<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(Request $request): View
    {
        $favorites = $request->user()->favorites()
            ->with(['favoriteUser.role', 'favoriteUser.nation', 'favoriteUser.riotAccount.rank', 'favoriteUser.membership.team'])
            ->latest()
            ->get();

        return view('favorites.index', ['favorites' => $favorites]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->withErrors(['favorite' => 'You cannot favourite yourself.']);
        }

        $request->user()->favorites()->firstOrCreate(['favorite_user_id' => $user->id]);

        return back()->with('status', $user->username.' added to your favourites.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $request->user()->favorites()->where('favorite_user_id', $user->id)->delete();

        return back()->with('status', $user->username.' removed from your favourites.');
    }
}
