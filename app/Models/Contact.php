<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'place_id',
        'name',
        'occupation',
        'email',
        'phone',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
