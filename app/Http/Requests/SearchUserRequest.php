<?php

namespace App\Http\Requests;

use App\Rules\AvailableUser;
use Illuminate\Foundation\Http\FormRequest;

class SearchUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['string', new AvailableUser],
        ];
    }
}
