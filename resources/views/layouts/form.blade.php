@extends('layouts.app')

@section('content')
<div class="ls-content">
  <div class="ls-banner"><span>LOLSCOUT</span></div>
  <div class="ls-main">
    <div class="ls-form">
      @if (session('status'))
        <p class="alert-text-success">{{ session('status') }}</p>
      @endif
      @if ($errors->any())
        @foreach ($errors->all() as $error)
          <p class="alert-text">{{ $error }}</p>
        @endforeach
      @endif
      @yield('form')
    </div>
  </div>
</div>
@endsection
