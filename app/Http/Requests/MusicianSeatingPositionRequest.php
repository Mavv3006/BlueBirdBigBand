<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MusicianSeatingPositionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'data' => 'required|array',
            'data.*.musicians' => 'required|array',
            'data.*.musicians.*.id' => 'required|numeric',
            'data.*.instrument_id' => 'required|numeric',
        ];
    }
}
