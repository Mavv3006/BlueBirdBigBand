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

//        dd($this);

        return [
            'id' => $this->id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'venue_street' => $this->venue_street,
            'venue_street_number' => $this->venue_street_number,
            'venue_description' => $this->venue_description,
            'event_description' => $this->event_description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
