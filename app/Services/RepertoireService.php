<?php

namespace App\Services;

use App\Models\Concert;
use App\Models\Song;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;

class RepertoireService
{
    public static function getCurrentRepertoire(int $limit = 5): Collection
    {
        return Song::join('setlist_entries', 'songs.id', '=', 'setlist_entries.song_id')
            ->joinSub(
                Concert::limit($limit)->orderBy('date', 'desc'),
                'concerts',
                fn (JoinClause $join) => $join->on('setlist_entries.concert_id', '=', 'concerts.id')
            )
            ->get();
    }
}
