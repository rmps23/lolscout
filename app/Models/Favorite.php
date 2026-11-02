<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'favorite_user_id'])]
class Favorite extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'favorite_user_id');
    }
}
