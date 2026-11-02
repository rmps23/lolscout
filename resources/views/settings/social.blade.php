@extends('layouts.page')
@section('title', 'Social links · LOLSCOUT')
@section('container-class', 'container-narrow')

@section('main')
<div class="page-head"><h1 class="page-title">Settings</h1></div>
@include('partials.settings-tabs')

<section class="card">
  <h2>Social links</h2>
  <p class="muted field">Only https links to the platform itself are accepted. Leave a field empty to remove it.</p>
  <form method="POST" action="{{ route('settings.social.update') }}">
    @csrf @method('PUT')
    @include('partials.social-form', ['links' => $links])
    <button type="submit" class="btn">Save</button>
  </form>
</section>
@endsection
