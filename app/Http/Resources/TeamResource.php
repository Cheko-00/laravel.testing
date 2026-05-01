<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/** @mixin Team */class TeamResource extends JsonResource{
    public function toArray(Request $request)
    {
        return [
'id' => $this->id,
'name' => $this->name,
'description' => $this->description,
'is_active' => $this->is_active,
'created_at' => $this->created_at,
'updated_at' => $this->updated_at,//
        ];
    }
}
