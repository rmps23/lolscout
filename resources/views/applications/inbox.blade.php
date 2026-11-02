@extends('layouts.form')
@section('title', 'Notifications · LOLSCOUT')

@section('form')
<h3 class="ls-text">Applications to your team</h3>
@error('application')<p class="alert-text">{{ $message }}</p>@enderror
@forelse ($applications as $application)
  <p class="ls-text">
    <a href="{{ route('players.show', $application->user) }}">{{ $application->user->username }}</a>
    wants to join <strong>{{ $application->team->name }}</strong> as {{ $application->role->name }}
    @if ($application->user->riotAccount?->isVerified() && $application->user->riotAccount->rank) · {{ $application->user->riotAccount->rank->name }}@endif
    <form method="POST" action="{{ route('applications.accept', $application) }}" style="display:inline;">@csrf<button type="submit">Accept</button></form>
    <form method="POST" action="{{ route('applications.decline', $application) }}" style="display:inline;">@csrf<button type="submit">Decline</button></form>
  </p>
@empty
  <p class="ls-text">Nothing new.</p>
@endforelse
@endsection
