@extends('layouts.form')
@section('title', 'Verify email · LOLSCOUT')
@section('subheading', 'One more step')

@section('form')
<p class="muted field">We sent a verification link to <strong style="color:var(--text)">{{ auth()->user()->email }}</strong>. Open it to activate your account.</p>
<form method="POST" action="{{ route('verification.send') }}">
  @csrf
  <button type="submit" class="btn btn-ghost btn-block">Resend verification email</button>
</form>
@endsection
