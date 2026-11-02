@foreach (array_keys(\App\Models\SocialLink::PLATFORMS) as $platform)
  <p class="ls-text">{{ ucfirst($platform) }}</p>
  <input type="url" class="ls-textbox" name="{{ $platform }}" value="{{ old($platform, $links[$platform] ?? '') }}" maxlength="255" placeholder="https://">
  @error($platform)<p class="alert-text">{{ $message }}</p>@enderror
@endforeach
