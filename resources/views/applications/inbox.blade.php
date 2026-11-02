@extends('layouts.page')
@section('title', 'Notifications · LOLSCOUT')

@section('main')
<div class="page-head"><h1 class="page-title">Applications to your team</h1></div>
<section class="card">
  <ul class="list">
    @forelse ($applications as $application)
      @php $account = $application->user->riotAccount?->isVerified() ? $application->user->riotAccount : null; @endphp
      <li class="list-item">
        <div class="grow">
          <a href="{{ route('players.show', $application->user) }}">{{ $application->user->username }}</a>
          <span class="muted">wants to join <strong style="color:var(--text)">{{ $application->team->name }}</strong> as {{ $application->role->name }}</span>
          @if ($account?->rank)<div>@include('partials.rank', ['rank' => $account->rank, 'lp' => $account->league_points])</div>@endif
        </div>
        <form class="inline" method="POST" action="{{ route('applications.accept', $application) }}">@csrf<button type="submit" class="btn btn-sm">Accept</button></form>
        <form class="inline" method="POST" action="{{ route('applications.decline', $application) }}">@csrf<button type="submit" class="btn btn-ghost btn-sm">Decline</button></form>
      </li>
    @empty
      <li class="empty">Nothing new.</li>
    @endforelse
  </ul>
</section>
@endsection
