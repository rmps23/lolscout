@extends('layouts.page')
@section('title', 'Account settings · LOLSCOUT')
@section('container-class', 'container-narrow')

@section('main')
<div class="page-head"><h1 class="page-title">Settings</h1></div>
@include('partials.settings-tabs')

<section class="card">
  <h2>Profile</h2>
  <form method="POST" action="{{ route('settings.profile') }}">
    @csrf @method('PUT')
    <div class="field">
      <label class="label" for="username">Username</label>
      <input class="input" id="username" type="text" name="username" value="{{ old('username', $user->username) }}" maxlength="30" required>
    </div>
    <div class="grid-2">
      <div class="field">
        <label class="label" for="role_id">Role</label>
        <select class="input" id="role_id" name="role_id">
          @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label class="label" for="nation_id">Nation</label>
        <select class="input" id="nation_id" name="nation_id">
          @foreach ($nations as $nation)
            <option value="{{ $nation->id }}" @selected(old('nation_id', $user->nation_id) == $nation->id)>{{ $nation->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="field">
      <label class="label" for="bio">About me</label>
      <textarea class="input" id="bio" name="bio" rows="4" maxlength="500">{{ old('bio', $user->bio) }}</textarea>
    </div>
    <button type="submit" class="btn">Save profile</button>
  </form>
</section>

<section class="card">
  <h2>Email</h2>
  <form method="POST" action="{{ route('settings.email') }}">
    @csrf @method('PUT')
    <div class="field">
      <label class="label" for="email">Email</label>
      <input class="input" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
      <p class="hint">A new address has to be verified again.</p>
    </div>
    <div class="field">
      <label class="label" for="email-password">Current password</label>
      <input class="input" id="email-password" type="password" name="current_password" autocomplete="current-password" required>
    </div>
    <button type="submit" class="btn">Change email</button>
  </form>
</section>

<section class="card">
  <h2>Password</h2>
  <form method="POST" action="{{ route('settings.password') }}">
    @csrf @method('PUT')
    <div class="field">
      <label class="label" for="current_password">Current password</label>
      <input class="input" id="current_password" type="password" name="current_password" autocomplete="current-password" required>
    </div>
    <div class="field">
      <label class="label" for="password">New password</label>
      <input class="input" id="password" type="password" name="password" autocomplete="new-password" required>
    </div>
    <div class="field">
      <label class="label" for="password_confirmation">Repeat new password</label>
      <input class="input" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
    </div>
    <button type="submit" class="btn">Change password</button>
  </form>
</section>

<section class="card" style="border-color:var(--danger)">
  <h2>Delete account</h2>
  <p class="muted field">This permanently removes your profile, team memberships and applications.</p>
  <form method="POST" action="{{ route('settings.destroy') }}" onsubmit="return confirm('Delete your account permanently?');">
    @csrf @method('DELETE')
    <div class="field">
      <label class="label" for="delete_password">Password</label>
      <input class="input" id="delete_password" type="password" name="delete_password" autocomplete="current-password" required>
    </div>
    <button type="submit" class="btn btn-danger">Delete my account</button>
  </form>
</section>
@endsection
