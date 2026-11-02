@extends('layouts.form')
@section('title', 'My applications · LOLSCOUT')

@section('form')
<h3 class="ls-text">My applications</h3>
@forelse ($applications as $application)
  <p class="ls-text">
    <a href="{{ route('teams.show', $application->team) }}">[{{ $application->team->tag }}] {{ $application->team->name }}</a>
    as {{ $application->role->name }} — {{ $application->status }}
    @if ($application->status === 'pending')
      <form method="POST" action="{{ route('applications.destroy', $application) }}" style="display:inline;">
        @csrf @method('DELETE')<button type="submit">Cancel</button>
      </form>
    @endif
  </p>
@empty
  <p class="ls-text">You have not applied to any team yet. <a href="{{ route('teams.search') }}">Search teams</a></p>
@endforelse
@endsection
