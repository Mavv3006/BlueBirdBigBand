<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConcertRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'after:today'],
            'band_id' => ['required', 'exists:bands,id'],
            'times.start' => ['required', 'string'],
            'times.end' => ['required', 'string'],
            'venue.street' => ['string', 'nullable'],
            'venue.house_number' => ['string', 'between:0,5'],
            'venue.create_new_venue' => ['required', 'boolean'],
            'venue.new_plz' => [
                'exclude_if:venue.create_new_venue,false',
                'required',
                'digits:5',
                'integer',
            ],
            'venue.new_name' => [
                'exclude_if:venue.create_new_venue,false',
                'required',
                'string',
            ],
            'venue.selected_plz' => [
                'exclude_if:venue.create_new_venue,true',
                'required',
                'integer',
                'digits:5',
                'exists:venues,plz',
            ],
            'description.event' => ['required', 'string'],
            'description.venue' => ['required', 'string'],
        ];
    }
}
