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
        'region_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function emergencyPlants()
    {
        return $this->hasMany(EmergencyPlant::class);
    }

    public function airConditioners()
    {
        return $this->hasMany(AirConditioner::class);
    }   
}
