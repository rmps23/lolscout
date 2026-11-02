<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'puuid', 'game_name', 'tag_line', 'profile_icon_id', 'rank_id', 'league_points', 'verified_at', 'synced_at'])]
class RiotAccount extends Model
{
    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'synced_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function getRiotIdAttribute(): string
    {
        return $this->game_name.'#'.$this->tag_line;
    }
}
