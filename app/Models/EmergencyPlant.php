<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyPlant extends Model
{
    protected $fillable = [
        'place_id',
        'capacitance',
        'trademark',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
