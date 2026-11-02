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
    <p class="auth-foot">This is a demo. Log in as <strong>demo@lolscout.test</strong> (password provided by the site owner).</p>
  @else
    <p class="auth-foot">No account yet? <a href="{{ route('register') }}">Sign up</a></p>
  @endif
</form>
@endsection
