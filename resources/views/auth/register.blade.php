@extends('layouts.form')
@section('title', 'Sign up · LOLSCOUT')

@section('form')
<form method="POST" action="{{ route('register') }}">
  @csrf
  <p class="ls-text">Username</p>
  <input type="text" class="ls-textbox" name="username" value="{{ old('username') }}" maxlength="30" required>
  <p class="ls-text">Email</p>
  <input type="email" class="ls-textbox" name="email" value="{{ old('email') }}" required>
  <p class="ls-text">Password</p>
  <input type="password" class="ls-textbox" name="password" autocomplete="new-password" required>
  <p class="ls-text">Repeat password</p>
  <input type="password" class="ls-textbox" name="password_confirmation" autocomplete="new-password" required>
  <p class="ls-text">Nation</p>
  <select class="ls-textbox" name="nation_id" required>
    @foreach ($nations as $nation)
      <option value="{{ $nation->id }}" @selected(old('nation_id') == $nation->id)>{{ $nation->name }}</option>
    @endforeach
  </select>
  <p class="ls-text">Role</p>
  <select class="ls-textbox" name="role_id" required>
    @foreach ($roles as $role)
      <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
    @endforeach
  </select>
  <p class="ls-text">Already have an account? <a href="{{ route('login') }}">Login</a></p>
  <button type="submit" class="ls-button">Sign up</button>
</form>
@endsection
