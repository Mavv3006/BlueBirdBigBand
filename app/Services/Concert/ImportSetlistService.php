<?php

namespace App\Services\Concert;

use App\Models\Concert;
use App\Models\SetlistEntry;
use App\Models\Song;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImportSetlistService
{
    /**
     * @var Collection The complete song list from the database.
     */
    private Collection $allSongs;

    /**
     * Extracts the concert date from a setlist text.
     *
     * This function iterates through each line of the provided text,
     * searching for the first non-empty line. It then assumes the date
     * is the first word of that line and returns it.
     *
     * @param string $textData The full setlist as a string.
     * @return string|null The concert date in 'Y-m-d' format if found, otherwise null.
     */
    public function extractConcertDate(string $textData): ?string
    {
        $lines = explode("\n", $textData);

        for ($i = 0; $i < count($lines); $i++) {
            $trimmed = trim($lines[$i]);

            if (!empty($trimmed)) {
                return explode(' ', $trimmed)[0];
            }
        }

        return null;
    }

    /**
     * Finds a concert record in the database based on the date extracted from the provided text.
     *
     * This function first calls `extractConcertDate` to get the date from the text data.
     * It then queries the database to find a `Concert` record with a matching date.
     * If a matching record is found, it is returned. If no concert is found for the given date,
     * a `ModelNotFoundException` is thrown.
     *
     * @param string $textData The full setlist as a string, from which the date will be extracted.
     * @return Concert The found Concert model instance.
     *
     * @throws ModelNotFoundException Thrown if no concert is found for the extracted date.
     */
    public function findConcert(string $textData): Concert
    {
        $date = $this->extractConcertDate($textData);

        return Concert::where('date', $date)->firstOrFail();
    }

    /**
     * Extracts songs from the setlist text and finds the most similar ones in the database.
     *
     * @param string $textData The full setlist text.
     * @return array A key-value array suitable for a Filament component.
     */
    public function extractSongs(string $textData): array
    {
        $lines = explode("\n", $textData);
        $foundSongs = [];
        $this->allSongs = Song::select(['id', 'title', 'arranger'])->get();

        for ($i = 2; $i < count($lines); $i++) {
            $trimmed = trim($lines[$i]);

            if (empty($trimmed) || str_contains($trimmed, '+++')) {
                continue;
            }

            $splittedEntry = $this->splitSetlistEntry($trimmed);
            $foundSong = $this->getSimilarSong($splittedEntry['title'], $splittedEntry['arranger']);

            if ($foundSong) {
                $foundSongs[] = "{$foundSong->title} (ID {$foundSong->id})";
            }
        }

        return $foundSongs;
    }

    /**
     * @return array{title: string, arranger: string}
     */
    public function splitSetlistEntry(string $setlistEntryString): array
    {
        $pattern = '/^(.+)\s+von\s+(.+)$/i';
        $matches = [];

        $arranger = null;

        if (preg_match($pattern, $setlistEntryString, $matches)) {
            $title = trim($matches[1]);
            $arranger = trim($matches[2]);
        } else {
            $title = trim($setlistEntryString);
        }

        $firstChar = mb_substr($title, 0, 1);
        $lastChar = mb_substr($title, -1);
        if (mb_strlen($title) >= 2 && !ctype_alnum($firstChar) && !ctype_alnum($lastChar)) {
            $title = mb_substr($title, 1, -1);
        }

        return [
            'title' => $title,
            'arranger' => $arranger,
        ];

    }

    private function getSimilarSong(string $title, ?string $arranger = null): ?Song
    {
        $foundSong = null;
        $highestSimilarity = 0;

        foreach ($this->allSongs as $song) {
            similar_text($title, $song->title, $titlePercent);

            $totalPercent = $titlePercent;

            if ($arranger && $song->arranger) {
                similar_text($arranger, $song->arranger, $arrangerPercent);

                $totalPercent = ($titlePercent * 0.7) + ($arrangerPercent * 0.3);
            }

            if ($totalPercent >= 50 && $totalPercent > $highestSimilarity) {
                $highestSimilarity = $totalPercent;
                $foundSong = $song;
            }
        }

        return $foundSong;
    }

    /**
     * @throws Throwable
     */
    public function saveSetlist(array $setlist, Concert $concert): void
    {
        DB::transaction(function () use ($setlist, $concert) {
            collect($this->getSongIdsFromSetlistArray($setlist))
                ->map(fn (int $value, int $key) => new SetlistEntry(['song_id' => $value, 'sequence_number' => $key]))
                ->each(fn (SetlistEntry $value) => $concert->setlist()->save($value));
        });
    }

    private function getSongIdsFromSetlistArray(array $setlist): array
    {
        $songIds = [];
        foreach ($setlist as $setlistItem) {
            $matches = [];
            if (preg_match('/ID (\d+)\)/', $setlistItem, $matches)) {
                $songIds[] = (int) $matches[1];
            }
        }

        return $songIds;
    }
}
