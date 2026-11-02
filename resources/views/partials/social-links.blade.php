@php $links = $owner->socialLinks; @endphp
@if ($links->isNotEmpty())
  <p class="ls-text">
    @foreach ($links as $link)
      <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer nofollow">
        <img src="{{ asset('images/socials/'.$link->platform.'.png') }}" width="24" height="24" alt="{{ ucfirst($link->platform) }}">
      </a>
    @endforeach
  </p>
@endif
