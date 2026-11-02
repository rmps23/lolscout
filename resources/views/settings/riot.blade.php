@extends('layouts.page')
@section('title', 'Riot account · LOLSCOUT')
@section('container-class', 'container-narrow')

@section('main')
<div class="page-head"><h1 class="page-title">Settings</h1></div>
@include('partials.settings-tabs')

<section class="card">
  <h2>Riot account</h2>

  @if ($account && $account->isVerified())
    <div class="row field">
      @if ($iconUrl)<img class="avatar" src="{{ $iconUrl }}" alt="">@endif
      <div class="grow">
        <div><strong>{{ $account->riot_id }}</strong> <span class="badge badge-accent">verified</span></div>
        @if ($account->rank)
          @include('partials.rank', ['rank' => $account->rank, 'lp' => $account->league_points])
        @else
          <span class="muted">Rank not synced yet.</span>
        @endif
      </div>
    </div>
    <div class="row">
      <form method="POST" action="{{ route('settings.riot.refresh') }}">
        @csrf
        <button type="submit" class="btn" @disabled(! $canRefresh)>Refresh rank</button>
      </form>
      <form method="POST" action="{{ route('settings.riot.destroy') }}" onsubmit="return confirm('Unlink this Riot account?');">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Unlink</button>
      </form>
    </div>
    @unless ($canRefresh)<p class="hint">You can refresh again a few minutes after the last update.</p>@endunless

  @elseif ($account)
    <p class="muted field">Linking <strong style="color:var(--text)">{{ $account->riot_id }}</strong>. In the League client open <em>Settings › Verification</em> and save this code:</p>
    <p class="field"><span class="code">{{ $account->verification_code }}</span></p>
    <p class="hint field">Then press Verify. The client can take a minute to publish the code.</p>
    <div class="row">
      <form method="POST" action="{{ route('settings.riot.verify') }}">
        @csrf
        <button type="submit" class="btn">Verify</button>
      </form>
      <form method="POST" action="{{ route('settings.riot.destroy') }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-ghost">Cancel</button>
      </form>
    </div>

  @else
    <p class="muted field">Link your Riot account to show your verified rank and champion mastery.</p>
    <form method="POST" action="{{ route('settings.riot.link') }}">
      @csrf
      <div class="field">
        <label class="label" for="riot_id">Riot ID</label>
        <input class="input" id="riot_id" type="text" name="riot_id" value="{{ old('riot_id') }}" placeholder="Name#TAG" required>
      </div>
      <button type="submit" class="btn">Link account</button>
    </form>
  @endif
</section>
@endsection
