@extends('layouts.app')
@section('title', $player->username.' · LOLSCOUT')

@section('content')
<div class="ls-content">
  <div class="ls-main">
    <div class="ls-form">
      @if ($iconUrl)<img src="{{ $iconUrl }}" width="96" height="96" alt="">@endif
      <h2 class="ls-text">{{ $player->username }}</h2>
      <p class="ls-text">
        @if ($player->role)<img src="{{ asset('images/roles/'.$player->role->image) }}" width="24" alt=""> {{ $player->role->name }}@endif
        @if ($player->nation) · <img src="{{ asset('images/nations/'.$player->nation->image) }}" width="24" alt=""> {{ $player->nation->name }}@endif
      </p>

      @if ($account)
        <p class="ls-text">{{ $account->riot_id }}</p>
        <p class="ls-text">
          @if ($account->rank)
            <img src="{{ asset('images/ranks/'.$account->rank->image) }}" width="40" alt="">
            {{ $account->rank->name }}@if ($account->league_points !== null) · {{ $account->league_points }} LP @endif
          @endif
        </p>

        @if ($champions)
          <h3 class="ls-text">Top champions</h3>
          @foreach ($champions as $mastery)
            <p class="ls-text">
              @if ($mastery['champion'])<img src="{{ $mastery['champion']['image'] }}" width="48" height="48" alt="">@endif
              {{ $mastery['champion']['name'] ?? 'Champion '.$mastery['championId'] }}
              · level {{ $mastery['championLevel'] }} · {{ number_format($mastery['championPoints']) }} points
            </p>
          @endforeach
        @endif
      @else
        <p class="ls-text">No verified Riot account.</p>
      @endif

      @if ($player->bio)<p class="ls-text">{{ $player->bio }}</p>@endif
      @if ($player->membership)
        <p class="ls-text">Team: <a href="{{ route('teams.show', $player->membership->team_id) }}">{{ $player->membership->team->name }}</a></p>
      @endif
      @include('partials.social-links', ['owner' => $player])

      @error('favorite')<p class="alert-text">{{ $message }}</p>@enderror
      @unless ($player->is(auth()->user()))
        @if ($isFavorite)
          <form method="POST" action="{{ route('favorites.destroy', $player) }}">@csrf @method('DELETE')<button type="submit" class="ls-button">Remove from favourites</button></form>
        @else
          <form method="POST" action="{{ route('favorites.store', $player) }}">@csrf<button type="submit" class="ls-button">Add to favourites</button></form>
        @endif
      @endunless
    </div>
  </div>
</div>
@endsection
