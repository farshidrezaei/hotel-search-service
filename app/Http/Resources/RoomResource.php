<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/** @mixin \App\Models\Room */
class RoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['id'],
            'beds_count' => $this->resource['beds_count'],
            'price_per_night' => $this->resource['price_per_night'],
            'special_properties' => $this->resource['specialProperties'],
            'created_at' => Carbon::make($this->resource['created_at'])->format('Y/m/d H:i:s'),
            'updated_at' => Carbon::make($this->resource['updated_at'])->format('Y/m/d H:i:s'),
        ];
    }
}
