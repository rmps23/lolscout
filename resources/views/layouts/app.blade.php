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
    @else
      <a class="navbar-link" href="{{ route('register') }}">Signup</a>
      <a class="navbar-link" href="{{ route('login') }}">Login</a>
    @endauth
  </div>

  @yield('content')
</body>
</html>
