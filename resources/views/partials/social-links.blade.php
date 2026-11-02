@php $links = $owner->socialLinks; @endphp
@if ($links->isNotEmpty())
  <div class="social">
    @foreach ($links as $link)
      <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer nofollow">
        <img src="{{ asset('images/socials/'.$link->platform.'.png') }}" alt="{{ ucfirst($link->platform) }}">
      </a>
    @endforeach
  </div>
@endif
