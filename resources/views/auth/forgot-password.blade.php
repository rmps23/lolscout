@extends('layouts.form')
@section('title', 'Forgot password · LOLSCOUT')

@section('form')
<form method="POST" action="{{ route('password.email') }}">
  @csrf
  <p class="ls-text">Enter your email and we will send you a reset link.</p>
  <input type="email" class="ls-textbox" name="email" value="{{ old('email') }}" required autofocus>
  <br><br>
  <button type="submit" class="ls-button">Send reset link</button>
</form>
@endsection
