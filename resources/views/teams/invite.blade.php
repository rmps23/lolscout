@extends('layouts.page')
@section('title', 'Team invitation · LOLSCOUT')
@section('container-class', 'container-narrow')

@section('main')
<section class="card" style="text-align:center">
  <img class="avatar avatar-lg" src="{{ $team->logoUrl() }}" alt="" style="margin:0 auto 14px; display:block">
  <p class="muted">You were invited to join</p>
  <h1 class="page-title"><span class="muted">[{{ $team->tag }}]</span> {{ $team->name }}</h1>
  <p class="muted field" style="margin-top:10px">You will join as {{ auth()->user()->role?->name ?? 'a player (set your role first)' }}.</p>
  <form method="POST" action="{{ route('invite.accept', $team->invite_code) }}">
    @csrf<button type="submit" class="btn">Accept invitation</button>
  </form>
</section>
@endsection
