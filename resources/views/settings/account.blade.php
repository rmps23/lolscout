@extends('layouts.form')
@section('title', 'Account settings · LOLSCOUT')

@section('form')
<h3 class="ls-text">Profile</h3>
<form method="POST" action="{{ route('settings.profile') }}">
  @csrf @method('PUT')
  <p class="ls-text">Username</p>
  <input type="text" class="ls-textbox" name="username" value="{{ old('username', $user->username) }}" maxlength="30" required>
  <p class="ls-text">Role</p>
  <select class="ls-textbox" name="role_id">
    @foreach ($roles as $role)
      <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) == $role->id)>{{ $role->name }}</option>
    @endforeach
  </select>
  <p class="ls-text">Nation</p>
  <select class="ls-textbox" name="nation_id">
    @foreach ($nations as $nation)
      <option value="{{ $nation->id }}" @selected(old('nation_id', $user->nation_id) == $nation->id)>{{ $nation->name }}</option>
    @endforeach
  </select>
  <p class="ls-text">About me</p>
  <textarea class="ls-textbox" name="bio" rows="4" maxlength="500">{{ old('bio', $user->bio) }}</textarea>
  <br><br>
  <button type="submit" class="ls-button">Save profile</button>
</form>

<hr>
<h3 class="ls-text">Email</h3>
<form method="POST" action="{{ route('settings.email') }}">
  @csrf @method('PUT')
  <input type="email" class="ls-textbox" name="email" value="{{ old('email', $user->email) }}" required>
  <p class="ls-text">Current password</p>
  <input type="password" class="ls-textbox" name="current_password" autocomplete="current-password" required>
  <br><br>
  <button type="submit" class="ls-button">Change email</button>
</form>

<hr>
<h3 class="ls-text">Password</h3>
<form method="POST" action="{{ route('settings.password') }}">
  @csrf @method('PUT')
  <p class="ls-text">Current password</p>
  <input type="password" class="ls-textbox" name="current_password" autocomplete="current-password" required>
  <p class="ls-text">New password</p>
  <input type="password" class="ls-textbox" name="password" autocomplete="new-password" required>
  <p class="ls-text">Repeat new password</p>
  <input type="password" class="ls-textbox" name="password_confirmation" autocomplete="new-password" required>
  <br><br>
  <button type="submit" class="ls-button">Change password</button>
</form>

<hr>
<h3 class="ls-text">Delete account</h3>
<form method="POST" action="{{ route('settings.destroy') }}" onsubmit="return confirm('Delete your account permanently?');">
  @csrf @method('DELETE')
  <p class="ls-text">Password</p>
  <input type="password" class="ls-textbox" name="delete_password" autocomplete="current-password" required>
  <br><br>
  <button type="submit" class="ls-button">Delete my account</button>
</form>
@endsection
