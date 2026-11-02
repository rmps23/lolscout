@extends('layouts.app')

@section('content')
<div class="auth">
  <div class="auth-card">
    <h1 class="auth-title">@yield('heading', 'LOLSCOUT')</h1>
    <p class="auth-sub">@yield('subheading')</p>
    @include('partials.flash')
    @yield('form')
  </div>
</div>
@endsection
