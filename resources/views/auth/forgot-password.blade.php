@extends('layouts.form')
@section('title', 'Forgot password · LOLSCOUT')
@section('subheading', 'We will email you a reset link')

@section('form')
<form method="POST" action="{{ route('password.email') }}">
  @csrf
  <div class="field">
    <label class="label" for="email">Email</label>
    <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
  </div>
  <button type="submit" class="btn btn-block">Send reset link</button>
  <p class="auth-foot"><a href="{{ route('login') }}">Back to login</a></p>
</form>
@endsection
