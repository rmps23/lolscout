@extends('layouts.page')
@section('title', 'My applications · LOLSCOUT')

@section('main')
<div class="page-head"><h1 class="page-title">My applications</h1></div>
<section class="card">
  <ul class="list">
    @forelse ($applications as $application)
      <li class="list-item">
        <img class="avatar" src="{{ $application->team->logoUrl() }}" alt="">
        <div class="grow">
          <a href="{{ route('teams.show', $application->team) }}">[{{ $application->team->tag }}] {{ $application->team->name }}</a>
          <div class="muted">as {{ $application->role->name }}</div>
        </div>
        <span @class(['badge', 'badge-accent' => $application->status === 'accepted', 'badge-danger' => $application->status === 'declined', 'badge-info' => $application->status === 'pending'])>{{ $application->status }}</span>
        @if ($application->status === 'pending')
          <form class="inline" method="POST" action="{{ route('applications.destroy', $application) }}">
            @csrf @method('DELETE')<button type="submit" class="btn btn-ghost btn-sm">Cancel</button>
          </form>
        @endif
      </li>
    @empty
      <li class="empty">You have not applied to any team yet. <a href="{{ route('teams.search') }}">Search teams</a></li>
    @endforelse
  </ul>
</section>
@endsection
