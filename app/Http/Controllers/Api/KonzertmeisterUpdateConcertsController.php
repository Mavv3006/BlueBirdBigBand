<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\KonzertmeisterIntegration\KonzertmeisterIntegrationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class KonzertmeisterUpdateConcertsController
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'apiKey' => [
                'required',
                'string',
                Rule::in([config('app.konzertmeister_api_key')]),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'error' => $validator->errors(),
            ], SymfonyResponse::HTTP_UNAUTHORIZED);
        }

        try {
            KonzertmeisterIntegrationService::pullNewData();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Fetching new data failed.',
                'error' => $e->getMessage(),
            ], SymfonyResponse::HTTP_BAD_GATEWAY);
        }

        return response()->json(
            ['message' => 'The operation was performed successfully.'],
            SymfonyResponse::HTTP_ACCEPTED
        );
    }
}
