@extends('layouts.app')

@section('content')
<div class="index-bar1">
  <div class="index-bar1-bar">
    <span style="font-size: 20px;">WELCOME TO</span><br>
    <span>LOLSCOUT</span><br>
    @auth
      <p class="ls-text">Signed in as {{ auth()->user()->username }}</p>
      <a href="{{ route('settings.account') }}"><button>Settings</button></a>
    @else
      <a href="{{ route('login') }}"><button>Login</button></a>
      <a href="{{ route('register') }}"><button>Signup</button></a>
    @endauth
  </div>
</div>
@endsection
