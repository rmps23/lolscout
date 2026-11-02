@foreach (array_keys(\App\Models\SocialLink::PLATFORMS) as $platform)
  <div class="field">
    <label class="label" for="social-{{ $platform }}">{{ ucfirst($platform) }}</label>
    <input class="input" id="social-{{ $platform }}" type="url" name="{{ $platform }}" value="{{ old($platform, $links[$platform] ?? '') }}" maxlength="255" placeholder="https://">
  </div>
@endforeach
