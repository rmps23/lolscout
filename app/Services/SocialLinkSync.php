<?php

namespace App\Services;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SocialLinkSync
{
    /** Validation rules for the five platform fields. */
    public static function rules(): array
    {
        $rules = [];
        foreach (array_keys(SocialLink::PLATFORMS) as $platform) {
            $rules[$platform] = ['nullable', 'string', 'max:255', function (string $attribute, mixed $value, \Closure $fail) {
                if (! SocialLink::isValidFor($attribute, trim($value))) {
                    $fail('Enter a valid https link to '.ucfirst($attribute).'.');
                }
            }];
        }

        return $rules;
    }

    /** Validate the request and store the links; a blank field removes that link. */
    public function update(Request $request, Model $owner): void
    {
        $data = $request->validate(self::rules());

        foreach (array_keys(SocialLink::PLATFORMS) as $platform) {
            $url = trim((string) ($data[$platform] ?? ''));
            $existing = $owner->socialLinks()->where('platform', $platform);

            if ($url === '') {
                $existing->delete();
            } else {
                $owner->socialLinks()->updateOrCreate(['platform' => $platform], ['url' => $url]);
            }
        }
    }
}
