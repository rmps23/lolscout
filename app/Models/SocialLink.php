<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['platform', 'url'])]
class SocialLink extends Model
{
    /** Accepted hosts per platform. Links must be https and on one of these domains (or a subdomain). */
    public const PLATFORMS = [
        'facebook' => ['facebook.com', 'fb.com'],
        'instagram' => ['instagram.com'],
        'twitter' => ['twitter.com', 'x.com'],
        'twitch' => ['twitch.tv'],
        'youtube' => ['youtube.com', 'youtu.be'],
    ];

    /** True when $url is an https link on one of the platform's own domains. */
    public static function isValidFor(string $platform, string $url): bool
    {
        if (! isset(self::PLATFORMS[$platform]) || preg_match('/[\s\x00-\x1f]/', $url) || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        $parts = parse_url($url);
        if (($parts['scheme'] ?? null) !== 'https' || isset($parts['user']) || isset($parts['pass']) || empty($parts['host'])) {
            return false;
        }

        $host = strtolower($parts['host']);
        foreach (self::PLATFORMS[$platform] as $domain) {
            if ($host === $domain || str_ends_with($host, '.'.$domain)) {
                return true;
            }
        }

        return false;
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
