@extends('layouts.form')
@section('title', 'Edit '.$team->name.' · LOLSCOUT')

@section('form')
<a class="ls-back" href="{{ route('teams.show', $team) }}">◄ Back</a>
<h3 class="ls-text">Edit team</h3>
<form method="POST" action="{{ route('teams.update', $team) }}">
  @csrf @method('PUT')
  <p class="ls-text">Tag</p>
  <input type="text" class="ls-textbox" name="tag" value="{{ old('tag', $team->tag) }}" maxlength="6" required>
  <p class="ls-text">Name</p>
  <input type="text" class="ls-textbox" name="name" value="{{ old('name', $team->name) }}" maxlength="40" required>
  <p class="ls-text">Nation</p>
  <select class="ls-textbox" name="nation_id" required>
    @foreach ($nations as $nation)
      <option value="{{ $nation->id }}" @selected(old('nation_id', $team->nation_id) == $nation->id)>{{ $nation->name }}</option>
    @endforeach
  </select>
  <p class="ls-text">Minimum rank to apply</p>
  <select class="ls-textbox" name="min_rank_id">
    <option value="">No minimum</option>
    @foreach ($ranks as $rank)
      <option value="{{ $rank->id }}" @selected(old('min_rank_id', $team->min_rank_id) == $rank->id)>{{ $rank->name }}</option>
    @endforeach
  </select>
  <p class="ls-text">About the team</p>
  <textarea class="ls-textbox" name="info" rows="4" maxlength="1000">{{ old('info', $team->info) }}</textarea>
  <p class="ls-text"><label><input type="checkbox" name="looking_for_players" value="1" @checked(old('looking_for_players', $team->looking_for_players))> Looking for players</label></p>
  <button type="submit" class="ls-button">Save</button>
</form>

<hr>
<h3 class="ls-text">Logo</h3>
<img src="{{ $team->logoUrl() }}" width="96" height="96" alt="">
<form method="POST" action="{{ route('teams.logo', $team) }}" enctype="multipart/form-data">
  @csrf
  <input type="file" name="logo" accept="image/png,image/jpeg,image/webp" required>
  <p class="ls-text">PNG, JPG or WebP, up to 1 MB and 2000×2000 px.</p>
  <button type="submit" class="ls-button">Upload logo</button>
</form>

<hr>
<h3 class="ls-text">Social links</h3>
<form method="POST" action="{{ route('teams.social', $team) }}">
  @csrf @method('PUT')
  @include('partials.social-form', ['links' => $team->socialLinks->pluck('url', 'platform')])
  <br>
  <button type="submit" class="ls-button">Save social links</button>
</form>

<hr>
<h3 class="ls-text">Invite link</h3>
<p class="ls-text">Anyone with this link (and a free spot for their role) can join.</p>
<input type="text" class="ls-textbox" readonly value="{{ route('invite.show', $team->invite_code) }}" onfocus="this.select()">
<form method="POST" action="{{ route('teams.invite.regenerate', $team) }}">
  @csrf
  <button type="submit" class="ls-button">Create a new link</button>
</form>

<hr>
<h3 class="ls-text">Delete team</h3>
<form method="POST" action="{{ route('teams.destroy', $team) }}" onsubmit="return confirm('Delete this team permanently?');">
  @csrf @method('DELETE')
  <p class="ls-text">Type <strong>{{ $team->name }}</strong> to confirm</p>
  <input type="text" class="ls-textbox" name="confirm_name" required>
  <br><br>
  <button type="submit" class="ls-button">Delete team</button>
</form>
@endsection
