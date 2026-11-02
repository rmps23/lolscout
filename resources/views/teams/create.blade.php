@extends('layouts.page')
@section('title', 'Create team · LOLSCOUT')
@section('container-class', 'container-narrow')

@section('main')
<div class="page-head">
  <div>
    <h1 class="page-title">Create a team</h1>
    <p class="page-sub">You join your team with your own role ({{ auth()->user()->role?->name ?? 'none set' }}).</p>
  </div>
</div>
<section class="card">
  <form method="POST" action="{{ route('teams.store') }}">
    @csrf
    <div class="grid-2">
      <div class="field">
        <label class="label" for="tag">Tag</label>
        <input class="input" id="tag" type="text" name="tag" value="{{ old('tag') }}" maxlength="6" required>
        <p class="hint">2–6 letters or numbers.</p>
      </div>
      <div class="field">
        <label class="label" for="name">Name</label>
        <input class="input" id="name" type="text" name="name" value="{{ old('name') }}" maxlength="40" required>
      </div>
    </div>
    <div class="field">
      <label class="label" for="nation_id">Nation</label>
      <select class="input" id="nation_id" name="nation_id" required>
        @foreach ($nations as $nation)
          <option value="{{ $nation->id }}" @selected(old('nation_id', auth()->user()->nation_id) == $nation->id)>{{ $nation->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <label class="label" for="info">About the team</label>
      <textarea class="input" id="info" name="info" rows="4" maxlength="1000">{{ old('info') }}</textarea>
    </div>
    <button type="submit" class="btn">Create team</button>
  </form>
</section>
@endsection
