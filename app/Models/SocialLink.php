<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['platform', 'url'])]
class SocialLink extends Model
{
    public const PLATFORMS = ['facebook', 'instagram', 'twitter', 'twitch', 'youtube'];

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
