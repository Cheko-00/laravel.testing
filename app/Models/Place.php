<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'name',
        'code',
        'serial_number',
        'address',
        'localization',
        'status',
        'region_id'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
