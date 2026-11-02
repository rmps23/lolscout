@extends('layouts.form')
@section('title', 'Team invitation · LOLSCOUT')

@section('form')
@error('invite')<p class="alert-text">{{ $message }}</p>@enderror
<img src="{{ $team->logoUrl() }}" width="96" height="96" alt="">
<h3 class="ls-text">You were invited to [{{ $team->tag }}] {{ $team->name }}</h3>
<p class="ls-text">You will join as {{ auth()->user()->role?->name ?? 'a player (set your role first)' }}.</p>
<form method="POST" action="{{ route('invite.accept', $team->invite_code) }}">
  @csrf<button type="submit" class="ls-button">Accept invitation</button>
</form>
@endsection
