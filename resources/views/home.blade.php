@extends('layouts.app')

@section('content')
<section class="hero">
  <div>
    <p class="hero-kicker">WELCOME TO</p>
    <h1 class="hero-title">LOLSCOUT</h1>
    <p class="hero-text">Find your team. Verify your Riot account, show your rank and champion mastery, and join amateur League of Legends teams.</p>
    @auth
      @if (auth()->user()->hasVerifiedEmail())
        <a href="{{ route('teams.search') }}" class="btn">Search teams</a>
        <a href="{{ route('players.show', auth()->user()) }}" class="btn btn-ghost">My profile</a>
      @else
        <a href="{{ route('verification.notice') }}" class="btn">Verify your email</a>
      @endif
    @else
      <a href="{{ route('login') }}" class="btn btn-ghost">Login</a>
      <a href="{{ route('register') }}" class="btn">Sign up</a>
    @endauth
  </div>
</section>
@endsection
