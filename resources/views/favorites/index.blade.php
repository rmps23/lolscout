@extends('layouts.page')
@section('title', 'Favourites · LOLSCOUT')

@section('main')
<div class="page-head"><h1 class="page-title">Favourite players</h1></div>
<section class="card">
  <ul class="list">
    @forelse ($favorites as $favorite)
      @php $player = $favorite->favoriteUser; $account = $player->riotAccount?->isVerified() ? $player->riotAccount : null; @endphp
      <li class="list-item">
        <div class="grow">
          <a href="{{ route('players.show', $player) }}">{{ $player->username }}</a>
          <div class="muted">
            {{ $player->role?->name }}
            @if ($player->membership) · <a href="{{ route('teams.show', $player->membership->team_id) }}">{{ $player->membership->team->name }}</a>@else · free agent @endif
          </div>
        </div>
        @if ($account?->rank)@include('partials.rank', ['rank' => $account->rank, 'lp' => null])@endif
        <form class="inline" method="POST" action="{{ route('favorites.destroy', $player) }}">
          @csrf @method('DELETE')<button type="submit" class="btn btn-ghost btn-sm">Remove</button>
        </form>
      </li>
    @empty
      <li class="empty">No favourites yet. Open a player's profile and press "Add to favourites".</li>
    @endforelse
  </ul>
</section>
@endsection
