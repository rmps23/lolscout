@extends('layouts.form')
@section('title', 'Social links · LOLSCOUT')

@section('form')
<h3 class="ls-text">Social links</h3>
<p class="ls-text">Only https links to the platform itself are accepted. Leave a field empty to remove it.</p>
<form method="POST" action="{{ route('settings.social.update') }}">
  @csrf @method('PUT')
  @include('partials.social-form', ['links' => $links])
  <br>
  <button type="submit" class="ls-button">Save</button>
</form>
@endsection
