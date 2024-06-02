<?php

namespace App\Services;

use App\Models\Concert;
use App\Models\Song;
use Illuminate\Support\Collection;

class RepertoireService
{
    public static function getCurrentRepertoire(int $limit = 5): Collection
    {
        return Song::join('setlist_entries', 'songs.id', '=', 'setlist_entries.song_id')
            ->joinSub(
                query: Concert::limit($limit)->orderBy('date', 'desc'),
                as: 'concerts',
                first: fn ($join) => $join->on('setlist_entries.concert_id', '=', 'concerts.id')
            )
            ->select(['songs.title', 'songs.arranger', 'songs.author', 'songs.genre'])
            ->distinct()
            ->orderBy('songs.title')
            ->get();
    }
}
