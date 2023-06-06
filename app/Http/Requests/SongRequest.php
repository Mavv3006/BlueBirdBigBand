<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SongRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'string|required',
            'author' => 'string|required',
            'arranger' => 'string|required',
            'genre' => 'string|required',
            'file' => ['nullable', File::types(['audio/mpeg'])]
        ];
    }
}
