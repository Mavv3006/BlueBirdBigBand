<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\BandName;
use App\Models\Band;
use App\Services\KonzertmeisterIntegration\KonzertmeisterIntegrationService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class KonzertmeisterUpdateConcertsController
{
    public function __invoke(Request $request): ResponseFactory|Application|Response
    {
        $validator = Validator::make($request->all(), [
            'apiKey' => [
                'required',
                'string',
                Rule::in([config('app.konzertmeister_api_key')]),
            ],
            'band_name' => [
                'required',
                'string',
                Rule::enum(BandName::class),
            ],
        ]);

        if ($validator->fails()) {
            return response(null, SymfonyResponse::HTTP_BAD_REQUEST);
        }

        $band = match (BandName::fromString($validator->validated()['band_name'])) {
            BandName::BlueBird => Band::whereName(BandName::BlueBird->value)->firstOrFail(),
            BandName::DomeTown => Band::whereName(BandName::DomeTown->value)->firstOrFail(),
        };

        KonzertmeisterIntegrationService::pullNewData($band);

        return response(null, SymfonyResponse::HTTP_ACCEPTED);
    }
}
