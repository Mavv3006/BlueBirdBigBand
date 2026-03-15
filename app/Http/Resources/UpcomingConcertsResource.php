<?php

namespace App\Http\Resources;

use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Concert */
class UpcomingConcertsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_at' => $this->start_at->toIso8601String(),
            'end_at' => $this->end_at->toIso8601String(),
            'address' => [
                'street' => $this->venue_street,
                'house_number' => $this->venue_street_number,
                'zip_code' => $this->venue_plz,
                'city' => $this->venue->name,
                'full_address' => "$this->venue_street $this->venue_street_number, $this->venue_plz {$this->venue->name}",
            ],
            'location_name' => $this->venue_description,
            'description' => $this->event_description,
        ];
    }
}
