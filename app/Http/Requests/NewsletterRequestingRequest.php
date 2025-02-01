<?php

namespace App\Http\Requests;

use App\Enums\NewsletterType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterRequestingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['string', 'required', 'email'],
            'type' => ['required', 'string', Rule::enum(NewsletterType::class)],
            'data_privacy_consent' => ['boolean', 'required'],
        ];
    }
}
