@extends('layouts.form')
@section('title', 'Reset password · LOLSCOUT')
@section('subheading', 'Choose a new password')

@section('form')
<form method="POST" action="{{ route('password.update') }}">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <div class="field">
    <label class="label" for="email">Email</label>
    <input class="input" id="email" type="email" name="email" value="{{ old('email', $email) }}" required>
  </div>
  <div class="field">
    <label class="label" for="password">New password</label>
    <input class="input" id="password" type="password" name="password" autocomplete="new-password" required>
  </div>
  <div class="field">
    <label class="label" for="password_confirmation">Repeat new password</label>
    <input class="input" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
  </div>
  <button type="submit" class="btn btn-block">Reset password</button>
</form>
@endsection
