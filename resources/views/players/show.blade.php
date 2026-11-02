@extends('layouts.page')
@section('title', $player->username.' · LOLSCOUT')

@section('main')
<section class="card">
  <div class="row">
    @if ($iconUrl)
      <img class="avatar avatar-lg" src="{{ $iconUrl }}" alt="">
    @else
      <img class="avatar avatar-lg" src="{{ asset('images/no-icon.png') }}" alt="">
    @endif
    <div class="grow stack">
      <h1 class="page-title">{{ $player->username }}</h1>
      <div class="row">
        @if ($player->role)<span class="badge"><img src="{{ asset('images/roles/'.$player->role->image) }}" alt="">{{ $player->role->name }}</span>@endif
        @if ($player->nation)<span class="badge"><img src="{{ asset('images/nations/'.$player->nation->image) }}" alt="">{{ $player->nation->name }}</span>@endif
        @if ($account)<span class="badge badge-accent">Riot verified</span>@endif
      </div>
      @if ($account)
        <div class="row">
          <span class="muted">{{ $account->riot_id }}</span>
          @if ($account->rank) @include('partials.rank', ['rank' => $account->rank, 'lp' => $account->league_points]) @endif
        </div>
      @else
        <p class="muted">No verified Riot account.</p>
      @endif
    </div>
    @unless ($player->is(auth()->user()))
      @if ($isFavorite)
        <form method="POST" action="{{ route('favorites.destroy', $player) }}">@csrf @method('DELETE')<button type="submit" class="btn btn-ghost">Remove from favourites</button></form>
      @else
        <form method="POST" action="{{ route('favorites.store', $player) }}">@csrf<button type="submit" class="btn">Add to favourites</button></form>
      @endif
    @else
      <a class="btn btn-ghost" href="{{ route('settings.account') }}">Edit profile</a>
    @endunless
  </div>
</section>

<div class="grid-2">
  <section class="card">
    <h2>Top champions</h2>
    @forelse ($champions as $mastery)
      <div class="champ field">
        @if ($mastery['champion'])<img src="{{ $mastery['champion']['image'] }}" alt="">@endif
        <div>
          <div>{{ $mastery['champion']['name'] ?? 'Champion '.$mastery['championId'] }}</div>
          <div class="muted">Level {{ $mastery['championLevel'] }} · {{ number_format($mastery['championPoints']) }} points</div>
        </div>
      </div>
    @empty
      <p class="muted">{{ $account ? 'No champion data available right now.' : 'Champion mastery appears once a Riot account is verified.' }}</p>
    @endforelse
  </section>

  <section class="card stack">
    <h2>About</h2>
    @if ($player->bio)<p>{{ $player->bio }}</p>@else<p class="muted">Nothing here yet.</p>@endif
    @if ($player->membership)
      <p>Team: <a href="{{ route('teams.show', $player->membership->team_id) }}">{{ $player->membership->team->name }}</a></p>
    @else
      <p class="muted">Free agent</p>
    @endif
    @include('partials.social-links', ['owner' => $player])
  </section>
</div>
@endsection
