@extends('layouts.page')
@section('title', 'Search teams · LOLSCOUT')

@section('main')
<div class="page-head"><h1 class="page-title">Search teams</h1></div>

<form method="GET" action="{{ route('teams.search') }}" class="card">
  <div class="row">
    <div class="grow"><input class="input" type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Team name" maxlength="40" aria-label="Team name"></div>
    <div>
      <select class="input" name="role_id" aria-label="Open role">
        <option value="">Any open role</option>
        @foreach ($roles as $role)
          <option value="{{ $role->id }}" @selected(($filters['role_id'] ?? null) == $role->id)>{{ $role->name }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn">Search</button>
  </div>
  <label class="check" style="margin-top:14px"><input type="checkbox" name="eligible" value="1" @checked($eligible)> Only teams I can apply to by rank</label>
</form>

@if ($teams->isEmpty())
  <p class="empty">No teams found.</p>
@else
  <div class="grid">
    @foreach ($teams as $team)
      <article class="team-card">
        <div class="row">
          <img class="avatar" src="{{ $team->logoUrl() }}" alt="">
          <div class="grow">
            <a class="title" href="{{ route('teams.show', $team) }}">{{ $team->name }}</a>
            <div class="muted">[{{ $team->tag }}]</div>
          </div>
        </div>
        <div class="row">
          <span class="badge">{{ $team->members_count }}/8 players</span>
          @if ($team->nation)<span class="badge"><img src="{{ asset('images/nations/'.$team->nation->image) }}" alt="">{{ $team->nation->name }}</span>@endif
          @if ($team->minRank)<span class="badge badge-info">Min. {{ $team->minRank->name }}</span>@endif
        </div>
        <a class="btn btn-ghost btn-sm" href="{{ route('teams.show', $team) }}">View team</a>
      </article>
    @endforeach
  </div>
  {{ $teams->links() }}
@endif
@endsection
