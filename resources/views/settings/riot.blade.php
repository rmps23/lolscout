@extends('layouts.form')
@section('title', 'Riot account · LOLSCOUT')

@section('form')
<h3 class="ls-text">Riot account</h3>

@if ($account && $account->isVerified())
  <p class="ls-text">
    @if ($iconUrl)<img src="{{ $iconUrl }}" width="48" height="48" alt="">@endif
    <strong>{{ $account->riot_id }}</strong> — verified
  </p>
  <p class="ls-text">
    @if ($account->rank)
      <img src="{{ asset('images/ranks/'.$account->rank->image) }}" width="32" alt="">
      {{ $account->rank->name }}@if ($account->league_points !== null) · {{ $account->league_points }} LP @endif
    @else
      Rank not synced yet.
    @endif
  </p>
  @error('refresh')<p class="alert-text">{{ $message }}</p>@enderror
  <form method="POST" action="{{ route('settings.riot.refresh') }}">
    @csrf
    <button type="submit" class="ls-button" @disabled(! $canRefresh)>Refresh rank</button>
  </form>
  <br>
  <form method="POST" action="{{ route('settings.riot.destroy') }}" onsubmit="return confirm('Unlink this Riot account?');">
    @csrf @method('DELETE')
    <button type="submit" class="ls-button">Unlink</button>
  </form>
@elseif ($account)
  <p class="ls-text">Linking <strong>{{ $account->riot_id }}</strong>. Save this code in the League client under <em>Settings &gt; Verification</em>:</p>
  <p class="ls-text"><span style="color:#ab0000; font-size:22px;">{{ $account->verification_code }}</span></p>
  <p class="ls-text">Then press Verify. The client can take a minute to publish the code.</p>
  @error('verify')<p class="alert-text">{{ $message }}</p>@enderror
  <form method="POST" action="{{ route('settings.riot.verify') }}">
    @csrf
    <button type="submit" class="ls-button">Verify</button>
  </form>
  <br>
  <form method="POST" action="{{ route('settings.riot.destroy') }}">
    @csrf @method('DELETE')
    <button type="submit" class="ls-button">Cancel</button>
  </form>
@else
  <form method="POST" action="{{ route('settings.riot.link') }}">
    @csrf
    <p class="ls-text">Riot ID</p>
    <input type="text" class="ls-textbox" name="riot_id" value="{{ old('riot_id') }}" placeholder="Name#TAG" required>
    <br><br>
    <button type="submit" class="ls-button">Link account</button>
  </form>
@endif
@endsection
