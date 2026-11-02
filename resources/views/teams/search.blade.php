@extends('layouts.form')
@section('title', 'Search teams · LOLSCOUT')

@section('form')
<h3 class="ls-text">Search teams</h3>
<form method="GET" action="{{ route('teams.search') }}">
  <input type="text" class="ls-textbox" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Team name" maxlength="40">
  <select class="ls-textbox" name="role_id">
    <option value="">Any open role</option>
    @foreach ($roles as $role)
      <option value="{{ $role->id }}" @selected(($filters['role_id'] ?? null) == $role->id)>{{ $role->name }}</option>
    @endforeach
  </select>
  <p class="ls-text"><label><input type="checkbox" name="eligible" value="1" @checked($eligible)> Only teams I can apply to by rank</label></p>
  <button type="submit" class="ls-button">Search</button>
</form>
<hr>
@forelse ($teams as $team)
  <p class="ls-text">
    <img src="{{ $team->logoUrl() }}" width="40" height="40" alt="">
    <a href="{{ route('teams.show', $team) }}">[{{ $team->tag }}] {{ $team->name }}</a>
    · {{ $team->members_count }}/8 players
    @if ($team->minRank) · min. {{ $team->minRank->name }}@endif
  </p>
@empty
  <p class="ls-text">No teams found.</p>
@endforelse
{{ $teams->links() }}
@endsection
