<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MusicianRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname' => 'string|required',
            'lastname' => 'string|required',
            'isActive' => 'required|bool',
            'instrument_id' => 'integer|required|min:0',
        ];
    }
}
