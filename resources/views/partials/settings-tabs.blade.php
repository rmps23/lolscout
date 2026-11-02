<nav class="tabs" aria-label="Settings">
  <a href="{{ route('settings.account') }}" @class(['active' => request()->routeIs('settings.account')])>Account</a>
  <a href="{{ route('settings.riot') }}" @class(['active' => request()->routeIs('settings.riot')])>Riot account</a>
  <a href="{{ route('settings.social') }}" @class(['active' => request()->routeIs('settings.social')])>Social links</a>
</nav>
