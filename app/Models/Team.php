<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description', 'is_active'])]
class Team extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_user')->withPivot('role');
    }
    public function members()
    {
        return $this->users()->wherePivot('role', 'member');
    }
    public function leaders()
    {
        return $this->users()->wherePivot('role', 'leader');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

}
