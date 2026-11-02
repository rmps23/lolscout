<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Services\SocialLinkSync;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function __construct(private readonly SocialLinkSync $sync) {}

    public function edit(Request $request): View
    {
        return view('settings.social', ['links' => $request->user()->socialLinks->pluck('url', 'platform')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->sync->update($request, $request->user());

        return back()->with('status', 'Social links updated.');
    }

    public function updateTeam(Request $request, Team $team): RedirectResponse
    {
        Gate::authorize('update', $team);

        $this->sync->update($request, $team);

        return back()->with('status', 'Team social links updated.');
    }
}
