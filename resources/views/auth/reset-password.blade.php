@extends('layouts.form')
@section('title', 'Reset password · LOLSCOUT')

@section('form')
<form method="POST" action="{{ route('password.update') }}">
  @csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <p class="ls-text">Email</p>
  <input type="email" class="ls-textbox" name="email" value="{{ old('email', $email) }}" required>
  <p class="ls-text">New password</p>
  <input type="password" class="ls-textbox" name="password" autocomplete="new-password" required>
  <p class="ls-text">Repeat new password</p>
  <input type="password" class="ls-textbox" name="password_confirmation" autocomplete="new-password" required>
  <br><br>
  <button type="submit" class="ls-button">Reset password</button>
</form>
@endsection
