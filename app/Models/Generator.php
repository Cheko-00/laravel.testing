<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    protected $fillable = [
        'generator_brand',
        'generator_model',
        'serial_number',
    ];

    public function emergencyPlants()
    {
        return $this->hasMany(EmergencyPlant::class);
    }
}