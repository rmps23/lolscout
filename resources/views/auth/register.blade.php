@extends('layouts.form')
@section('title', 'Sign up · LOLSCOUT')
@section('subheading', 'Create your account')

@section('form')
<form method="POST" action="{{ route('register') }}">
  @csrf
  <div class="field">
    <label class="label" for="username">Username</label>
    <input class="input" id="username" type="text" name="username" value="{{ old('username') }}" maxlength="30" autocomplete="username" required>
  </div>
  <div class="field">
    <label class="label" for="email">Email</label>
    <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
  </div>
  <div class="field">
    <label class="label" for="password">Password</label>
    <input class="input" id="password" type="password" name="password" autocomplete="new-password" required>
    <p class="hint">At least 10 characters, with letters and numbers.</p>
  </div>
  <div class="field">
    <label class="label" for="password_confirmation">Repeat password</label>
    <input class="input" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
  </div>
  <div class="grid-2">
    <div class="field">
      <label class="label" for="nation_id">Nation</label>
      <select class="input" id="nation_id" name="nation_id" required>
        @foreach ($nations as $nation)
          <option value="{{ $nation->id }}" @selected(old('nation_id') == $nation->id)>{{ $nation->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <label class="label" for="role_id">Role</label>
      <select class="input" id="role_id" name="role_id" required>
        @foreach ($roles as $role)
          <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-block">Sign up</button>
  <p class="auth-foot">Already have an account? <a href="{{ route('login') }}">Login</a></p>
</form>
@endsection
