@extends('layouts.page')
@section('title', 'Edit '.$team->name.' · LOLSCOUT')
@section('container-class', 'container-narrow')

@section('main')
<div class="page-head">
  <h1 class="page-title">Edit team</h1>
  <a class="btn btn-ghost btn-sm" href="{{ route('teams.show', $team) }}">‹ Back to team</a>
</div>

<section class="card">
  <h2>Details</h2>
  <form method="POST" action="{{ route('teams.update', $team) }}">
    @csrf @method('PUT')
    <div class="grid-2">
      <div class="field">
        <label class="label" for="tag">Tag</label>
        <input class="input" id="tag" type="text" name="tag" value="{{ old('tag', $team->tag) }}" maxlength="6" required>
      </div>
      <div class="field">
        <label class="label" for="name">Name</label>
        <input class="input" id="name" type="text" name="name" value="{{ old('name', $team->name) }}" maxlength="40" required>
      </div>
    </div>
    <div class="grid-2">
      <div class="field">
        <label class="label" for="nation_id">Nation</label>
        <select class="input" id="nation_id" name="nation_id" required>
          @foreach ($nations as $nation)
            <option value="{{ $nation->id }}" @selected(old('nation_id', $team->nation_id) == $nation->id)>{{ $nation->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label class="label" for="min_rank_id">Minimum rank to apply</label>
        <select class="input" id="min_rank_id" name="min_rank_id">
          <option value="">No minimum</option>
          @foreach ($ranks as $rank)
            <option value="{{ $rank->id }}" @selected(old('min_rank_id', $team->min_rank_id) == $rank->id)>{{ $rank->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="field">
      <label class="label" for="info">About the team</label>
      <textarea class="input" id="info" name="info" rows="4" maxlength="1000">{{ old('info', $team->info) }}</textarea>
    </div>
    <div class="field">
      <label class="check"><input type="checkbox" name="looking_for_players" value="1" @checked(old('looking_for_players', $team->looking_for_players))> Looking for players</label>
    </div>
    <button type="submit" class="btn">Save</button>
  </form>
</section>

<section class="card">
  <h2>Logo</h2>
  <form method="POST" action="{{ route('teams.logo', $team) }}" enctype="multipart/form-data">
    @csrf
    <div class="row field">
      <img class="avatar avatar-lg" src="{{ $team->logoUrl() }}" alt="">
      <div class="grow">
        <input class="input" type="file" name="logo" accept="image/png,image/jpeg,image/webp" required>
        <p class="hint">PNG, JPG or WebP, up to 1 MB and 2000×2000 px.</p>
      </div>
    </div>
    <button type="submit" class="btn">Upload logo</button>
  </form>
</section>

<section class="card">
  <h2>Social links</h2>
  <form method="POST" action="{{ route('teams.social', $team) }}">
    @csrf @method('PUT')
    @include('partials.social-form', ['links' => $team->socialLinks->pluck('url', 'platform')])
    <button type="submit" class="btn">Save social links</button>
  </form>
</section>

<section class="card">
  <h2>Invite link</h2>
  <p class="muted field">Anyone with this link and a free spot for their role can join, even if the team is not recruiting.</p>
  <div class="field">
    <input class="input" type="text" readonly value="{{ route('invite.show', $team->invite_code) }}" onfocus="this.select()" aria-label="Invite link">
  </div>
  <form method="POST" action="{{ route('teams.invite.regenerate', $team) }}">
    @csrf
    <button type="submit" class="btn btn-ghost">Create a new link</button>
  </form>
</section>

<section class="card" style="border-color:var(--danger)">
  <h2>Delete team</h2>
  <form method="POST" action="{{ route('teams.destroy', $team) }}" onsubmit="return confirm('Delete this team permanently?');">
    @csrf @method('DELETE')
    <div class="field">
      <label class="label" for="confirm_name">Type <strong>{{ $team->name }}</strong> to confirm</label>
      <input class="input" id="confirm_name" type="text" name="confirm_name" required>
    </div>
    <button type="submit" class="btn btn-danger">Delete team</button>
  </form>
</section>
@endsection
