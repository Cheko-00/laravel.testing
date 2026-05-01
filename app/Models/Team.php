<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[Fillable(['name', 'description', 'is_active'])]
class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
