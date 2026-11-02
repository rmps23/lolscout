<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'name', 'image', 'is_player'])]
class Role extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return ['is_player' => 'boolean'];
    }
}
