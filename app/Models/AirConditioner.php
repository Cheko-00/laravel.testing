<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirConditioner extends Model
{
    protected $fillable = [
        'serial_number',
        'brand',
        'model',
        'capacity_tr',
        'refrigerant_type',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
