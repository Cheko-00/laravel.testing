<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $fillable = [
        'engine_brand',
        'engine_model',
        'serial_number',
    ];

    public function emergencyPlants()
    {
        return $this->hasMany(EmergencyPlant::class);
    }
}
