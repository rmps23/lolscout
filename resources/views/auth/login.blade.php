@extends('layouts.form')
@section('title', 'Login · LOLSCOUT')

@section('form')
<form method="POST" action="{{ route('login') }}">
  @csrf
  <p class="ls-text">Email</p>
  <input type="email" class="ls-textbox" name="email" value="{{ old('email') }}" required autofocus>
  <p class="ls-text">Password</p>
  <input type="password" class="ls-textbox" name="password" autocomplete="current-password" required>
  <p class="ls-text"><label><input type="checkbox" name="remember"> Remember me</label></p>
  <p class="ls-text">No account yet? <a href="{{ route('register') }}">Signup</a></p>
  <a class="ls-forgotpw" href="{{ route('password.request') }}">Forgot password?</a>
  <br><br>
  <button type="submit" class="ls-button">Login</button>
</form>
@endsection
