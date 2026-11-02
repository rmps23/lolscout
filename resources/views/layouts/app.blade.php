<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'LOLSCOUT')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <header class="nav">
    <div class="nav-inner">
      <a href="{{ route('home') }}" class="nav-logo">LOLSCOUT<small>beta</small></a>

      @auth
        @if (auth()->user()->hasVerifiedEmail())
          <input type="checkbox" id="nav-toggle" class="nav-toggle" aria-label="Toggle menu">
          <nav class="nav-links" aria-label="Main">
            <a href="{{ route('teams.search') }}" @class(['active' => request()->routeIs('teams.search')])>Search teams</a>
            <a href="{{ route('teams.mine') }}" @class(['active' => request()->is('teams') || request()->is('teams/create') || (request()->routeIs('teams.*') && ! request()->routeIs('teams.search'))])>My team</a>
            <a href="{{ route('applications.mine') }}" @class(['active' => request()->routeIs('applications.mine')])>My applies</a>
            <a href="{{ route('applications.inbox') }}" @class(['active' => request()->routeIs('applications.inbox')])>Notifications
              @if (($pending = auth()->user()->pendingInboxCount()) > 0)<span class="nav-count">{{ $pending }}</span>@endif
            </a>
            <a href="{{ route('favorites.index') }}" @class(['active' => request()->routeIs('favorites.index')])>Favourites</a>
          </nav>
          <label for="nav-toggle" class="nav-toggle-label" aria-hidden="true">☰</label>
        @endif

        <div class="nav-right">
          <details class="menu">
            <summary>{{ auth()->user()->username }}</summary>
            <div class="menu-panel">
              @if (auth()->user()->hasVerifiedEmail())
                <a href="{{ route('players.show', auth()->user()) }}">My profile</a>
                <a href="{{ route('settings.riot') }}">Riot account</a>
                <a href="{{ route('settings.social') }}">Social links</a>
                <a href="{{ route('settings.account') }}">Settings</a>
              @endif
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Log out</button>
              </form>
            </div>
          </details>
        </div>
      @else
        <div class="nav-right">
          <a class="btn btn-ghost btn-sm" href="{{ route('login') }}">Login</a>
          <a class="btn btn-sm" href="{{ route('register') }}">Sign up</a>
        </div>
      @endauth
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="footer">
    LOLSCOUT isn't endorsed by Riot Games and doesn't reflect the views or opinions of Riot Games or anyone officially involved in producing or managing Riot Games properties.
  </footer>
</body>
</html>
