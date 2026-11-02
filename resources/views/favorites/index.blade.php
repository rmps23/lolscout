@extends('layouts.form')
@section('title', 'Favourites · LOLSCOUT')

@section('form')
<h3 class="ls-text">Favourite players</h3>
@forelse ($favorites as $favorite)
  @php $player = $favorite->favoriteUser; $account = $player->riotAccount?->isVerified() ? $player->riotAccount : null; @endphp
  <p class="ls-text">
    <a href="{{ route('players.show', $player) }}">{{ $player->username }}</a>
    @if ($player->role) · {{ $player->role->name }}@endif
    @if ($account?->rank) · {{ $account->rank->name }}@endif
    @if ($player->membership) · <a href="{{ route('teams.show', $player->membership->team_id) }}">{{ $player->membership->team->name }}</a>@else · free agent @endif
    <form method="POST" action="{{ route('favorites.destroy', $player) }}" style="display:inline;">
      @csrf @method('DELETE')<button type="submit">Remove</button>
    </form>
  </p>
@empty
  <p class="ls-text">No favourites yet. Open a player's profile and press "Add to favourites".</p>
@endforelse
@endsection
