@extends('layouts.form')
@section('title', 'Create team · LOLSCOUT')

@section('form')
<h3 class="ls-text">Create a team</h3>
<p class="ls-text">You join your team with your own role ({{ auth()->user()->role?->name ?? 'none set' }}).</p>
<form method="POST" action="{{ route('teams.store') }}">
  @csrf
  <p class="ls-text">Tag (2–6 letters or numbers)</p>
  <input type="text" class="ls-textbox" name="tag" value="{{ old('tag') }}" maxlength="6" required>
  <p class="ls-text">Name</p>
  <input type="text" class="ls-textbox" name="name" value="{{ old('name') }}" maxlength="40" required>
  <p class="ls-text">Nation</p>
  <select class="ls-textbox" name="nation_id" required>
    @foreach ($nations as $nation)
      <option value="{{ $nation->id }}" @selected(old('nation_id', auth()->user()->nation_id) == $nation->id)>{{ $nation->name }}</option>
    @endforeach
  </select>
  <p class="ls-text">About the team</p>
  <textarea class="ls-textbox" name="info" rows="4" maxlength="1000">{{ old('info') }}</textarea>
  <br><br>
  <button type="submit" class="ls-button">Create team</button>
</form>
@endsection
