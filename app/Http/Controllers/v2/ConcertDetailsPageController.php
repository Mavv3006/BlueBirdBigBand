<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Services\Concert\ConcertService;
use Illuminate\Http\Request;

class ConcertDetailsPageController extends Controller
{
    public function __construct(public ConcertService $service)
    {
    }

    public function __invoke(Request $request, Concert $concert)
    {
        $setlistSongs = $concert
            ->setlist()
            ->first()
            ->entries()
            ->with('song')
            ->orderBy('sequence_number')
            ->get()
            ->map(fn ($entry) => $entry->song)
            ->unique()
            ->map(fn ($song) => [
                'title' => $song->title,
                'genre' => $song->genre,
                'author' => $song->author,
                'arranger' => $song->arranger,
            ]);

        return view('components.pages.concert-details', [
            'concert' => $this->service->formatConcert($concert),
            'setlistSongs' => $setlistSongs,
        ]);
    }
}
