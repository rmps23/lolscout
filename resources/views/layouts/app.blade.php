<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'LOLSCOUT')</title>
  <link rel="stylesheet" href="{{ asset('css/legacy.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="navbar">
    <a href="{{ route('home') }}" class="navbar-logo">LOLSCOUT <span style="font-size:12px; color:red;">beta</span></a>
    @auth
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="navbar-link" style="background:none;border:0;cursor:pointer;">Logout</button>
      </form>
      <a class="navbar-link" href="{{ route('settings.account') }}">Settings</a>
      <a class="navbar-link" href="{{ route('teams.search') }}">Search teams</a>
      <a class="navbar-link" href="{{ route('teams.mine') }}">My team</a>
      <a class="navbar-link" href="{{ route('applications.mine') }}">My applies</a>
      <a class="navbar-link" href="{{ route('applications.inbox') }}">Notifications @if (($n = auth()->user()->pendingInboxCount()) > 0)<span class="badge" style="color:#6BD0FF;">{{ $n }}</span>@endif</a>
      <a class="navbar-link" href="{{ route('favorites.index') }}">Favourites</a>
      <a class="navbar-link" href="{{ route('settings.riot') }}">Riot account</a>
      <a class="navbar-link" href="{{ route('settings.social') }}">Social</a>
      <a class="navbar-link" href="{{ route('players.show', auth()->user()) }}">Profile</a>
    @else
      <a class="navbar-link" href="{{ route('register') }}">Signup</a>
      <a class="navbar-link" href="{{ route('login') }}">Login</a>
    @endauth
  </div>

  @yield('content')
</body>
</html>
