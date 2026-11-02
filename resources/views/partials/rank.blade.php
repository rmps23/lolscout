@if ($rank)
  <span class="rank">
    <img src="{{ asset('images/ranks/'.$rank->image) }}" alt="">
    <span>{{ $rank->name }}@if ($lp !== null) <span class="muted">· {{ $lp }} LP</span>@endif</span>
  </span>
@endif
