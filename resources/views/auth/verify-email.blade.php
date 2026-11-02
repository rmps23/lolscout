@extends('layouts.form')
@section('title', 'Verify email · LOLSCOUT')

@section('form')
<p class="ls-text">We sent a verification link to {{ auth()->user()->email }}. Click it to activate your account.</p>
<form method="POST" action="{{ route('verification.send') }}">
  @csrf
  <button type="submit" class="ls-button">Resend verification email</button>
</form>
@endsection
