@extends('layouts.page')
@section('title', $team->name.' · LOLSCOUT')

@section('main')
<section class="card">
  <div class="row">
    <img class="avatar avatar-lg" src="{{ $team->logoUrl() }}" alt="">
    <div class="grow stack">
      <h1 class="page-title"><span class="muted">[{{ $team->tag }}]</span> {{ $team->name }}</h1>
      <div class="row">
        @if ($team->nation)<span class="badge"><img src="{{ asset('images/nations/'.$team->nation->image) }}" alt="">{{ $team->nation->name }}</span>@endif
        <span @class(['badge', 'badge-accent' => $team->looking_for_players])>{{ $team->looking_for_players ? 'Recruiting' : 'Not recruiting' }}</span>
        @if ($team->minRank)<span class="badge">Min. {{ $team->minRank->name }}</span>@endif
      </div>
      @include('partials.social-links', ['owner' => $team])
    </div>

    <div class="stack">
      @if ($isOwner)
        <a href="{{ route('teams.edit', $team) }}" class="btn">Edit team</a>
      @elseif ($isMember)
        <form method="POST" action="{{ route('teams.leave', $team) }}" onsubmit="return confirm('Leave this team?');">
          @csrf @method('DELETE')<button type="submit" class="btn btn-danger">Leave team</button>
        </form>
      @elseif ($application)
        <form method="POST" action="{{ route('applications.destroy', $application) }}">
          @csrf @method('DELETE')<button type="submit" class="btn btn-ghost">Cancel application</button>
        </form>
      @elseif (! $applyBlocker)
        <form method="POST" action="{{ route('teams.apply', $team) }}">
          @csrf<button type="submit" class="btn">Apply as {{ auth()->user()->role->name }}</button>
        </form>
      @endif
    </div>
  </div>

  @if (! $isOwner && ! $isMember)
    @if ($application)
      <p class="hint" style="margin-top:14px">You have a pending application.</p>
    @elseif ($applyBlocker)
      <p class="hint" style="margin-top:14px">{{ $applyBlocker }}</p>
    @endif
  @endif
</section>

@if ($team->info)
  <section class="card"><h2>About</h2><p>{{ $team->info }}</p></section>
@endif

<section class="card">
  <h2>Roster</h2>
  <ul class="list">
    @foreach ($team->members as $member)
      @php $account = $member->user->riotAccount?->isVerified() ? $member->user->riotAccount : null; @endphp
      <li class="list-item">
        <img class="icon" src="{{ asset('images/roles/'.$member->role->image) }}" alt="">
        <span class="muted" style="width:80px">{{ $member->role->name }}</span>
        <div class="grow">
          <a href="{{ route('players.show', $member->user) }}">{{ $member->user->username }}</a>
          @if ($member->user_id === $team->owner_id)<span class="badge">owner</span>@endif
        </div>
        @if ($account?->rank)@include('partials.rank', ['rank' => $account->rank, 'lp' => null])@endif
        @if ($isOwner && $member->user_id !== $team->owner_id)
          <form class="inline" method="POST" action="{{ route('teams.members.kick', [$team, $member]) }}" onsubmit="return confirm('Remove this player?');">
            @csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Remove</button>
          </form>
        @endif
      </li>
    @endforeach
    @foreach ($openRoles as $role)
      <li class="list-item">
        <img class="icon" src="{{ asset('images/roles/'.$role->image) }}" alt="" style="opacity:.5">
        <span class="muted" style="width:80px">{{ $role->name }}</span>
        <span class="muted"><em>open</em></span>
      </li>
    @endforeach
  </ul>
</section>
@endsection
