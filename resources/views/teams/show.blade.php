@extends('layouts.form')
@section('title', $team->name.' · LOLSCOUT')

@section('form')
<img src="{{ $team->logoUrl() }}" width="96" height="96" alt="">
<h2 class="ls-text">[{{ $team->tag }}] {{ $team->name }}</h2>
<p class="ls-text">
  @if ($team->nation)<img src="{{ asset('images/nations/'.$team->nation->image) }}" width="24" alt=""> {{ $team->nation->name }} · @endif
  {{ $team->looking_for_players ? 'Recruiting' : 'Not recruiting' }}
  @if ($team->minRank) · min. {{ $team->minRank->name }}@endif
</p>
@if ($team->info)<p class="ls-text">{{ $team->info }}</p>@endif

@include('partials.social-links', ['owner' => $team])

@error('member')<p class="alert-text">{{ $message }}</p>@enderror

<h3 class="ls-text">Roster</h3>
@foreach ($team->members as $member)
  <p class="ls-text">
    <img src="{{ asset('images/roles/'.$member->role->image) }}" width="24" alt="">
    {{ $member->role->name }}:
    <a href="{{ route('players.show', $member->user) }}">{{ $member->user->username }}</a>
    @if ($member->user_id === $team->owner_id) (owner)@endif
    @if ($member->user->riotAccount?->isVerified() && $member->user->riotAccount->rank) · {{ $member->user->riotAccount->rank->name }}@endif
    @if ($isOwner && $member->user_id !== $team->owner_id)
      <form method="POST" action="{{ route('teams.members.kick', [$team, $member]) }}" style="display:inline;" onsubmit="return confirm('Remove this player?');">
        @csrf @method('DELETE')<button type="submit">Remove</button>
      </form>
    @endif
  </p>
@endforeach
@foreach ($openRoles as $role)
  <p class="ls-text"><img src="{{ asset('images/roles/'.$role->image) }}" width="24" alt=""> {{ $role->name }}: <em>open</em></p>
@endforeach

@if ($isOwner)
  <a href="{{ route('teams.edit', $team) }}"><button class="ls-button">Edit team</button></a>
@elseif ($isMember)
  <form method="POST" action="{{ route('teams.leave', $team) }}" onsubmit="return confirm('Leave this team?');">
    @csrf @method('DELETE')<button type="submit" class="ls-button">Leave team</button>
  </form>
@else
  @error('apply')<p class="alert-text">{{ $message }}</p>@enderror
  @if ($application)
    <p class="ls-text">You have a pending application.</p>
    <form method="POST" action="{{ route('applications.destroy', $application) }}">
      @csrf @method('DELETE')<button type="submit" class="ls-button">Cancel application</button>
    </form>
  @elseif ($applyBlocker)
    <p class="ls-text">{{ $applyBlocker }}</p>
  @else
    <form method="POST" action="{{ route('teams.apply', $team) }}">
      @csrf<button type="submit" class="ls-button">Apply as {{ auth()->user()->role->name }}</button>
    </form>
  @endif
@endif
@endsection
