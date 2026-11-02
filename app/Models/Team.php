<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['owner_id', 'tag', 'name', 'info', 'logo_path', 'nation_id', 'min_rank_id', 'looking_for_players', 'invite_code'])]
class Team extends Model
{
    protected function casts(): array
    {
        return ['looking_for_players' => 'boolean'];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function nation(): BelongsTo
    {
        return $this->belongsTo(Nation::class);
    }

    public function minRank(): BelongsTo
    {
        return $this->belongsTo(Rank::class, 'min_rank_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function socialLinks(): MorphMany
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }
}
