<?php

namespace App\Http\Controllers\Api;

use App\Models\KonzertmeisterEvent;
use Carbon\Carbon;
use ICal\Event;
use ICal\ICal;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
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
        ]);

        if ($validator->fails()) {
            return response(null, SymfonyResponse::HTTP_BAD_REQUEST);
        }

        $this->pullNewConcertData();

        return response(null, SymfonyResponse::HTTP_ACCEPTED);
    }

    private function pullNewConcertData()
    {
        $calendar = new ICal(config('app.konzertmeister_url'), [
            'defaultTimeZone' => 'Europe/Berlin',
            'filterDaysBefore' => Carbon::now(),
        ]);

        Log::debug('KonzertmeisterUpdateConcertsController', ['event count' => count($calendar->events())]);
        Log::debug('', ['events' => $calendar->events()]);

        /** @var Event $event */
        foreach ($calendar->events() as $event) {
            KonzertmeisterEvent::firstOrCreate();
        }
    }
}
