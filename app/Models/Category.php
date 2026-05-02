<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'color', 'is_active'])]
class Category extends Model
{
    use HasFactory;

    protected $casts = ['is_active' => 'boolean'];
}
