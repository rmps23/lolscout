@extends('layouts.app')

@section('content')
<div class="container @yield('container-class')">
  @include('partials.flash')
  @yield('main')
</div>
@endsection
