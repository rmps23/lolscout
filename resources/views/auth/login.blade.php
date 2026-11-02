@extends('layouts.form')
@section('title', 'Login · LOLSCOUT')
@section('subheading', 'Welcome back')

@section('form')
<form method="POST" action="{{ route('login') }}">
  @csrf
  <div class="field">
    <label class="label" for="email">Email</label>
    <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
  </div>
  <div class="field">
    <label class="label" for="password">Password</label>
    <input class="input" id="password" type="password" name="password" autocomplete="current-password" required>
  </div>
  <div class="row row-between field">
    <label class="check"><input type="checkbox" name="remember"> Remember me</label>
    <a href="{{ route('password.request') }}">Forgot password?</a>
  </div>
  <button type="submit" class="btn btn-block">Login</button>
  @if (config('app.showcase'))
    <p class="auth-foot">This is a demo site. The button below signs you in to a shared example account, no password needed.</p>
  @else
    <p class="auth-foot">No account yet? <a href="{{ route('register') }}">Sign up</a></p>
  @endif
</form>
@if (config('app.showcase'))
<form method="POST" action="{{ route('demo.login') }}">
  @csrf
  <button type="submit" class="btn btn-block">Try the demo account</button>
</form>
@endif
@endsection
