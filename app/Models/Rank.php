<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tier', 'division', 'name', 'position', 'image'])]
class Rank extends Model
{
    public $timestamps = false;
}
