<?php

namespace App\Services\Setlist;

use App\DataTransferObjects\SetlistStatistics\SetlistCountDto;
use DB;

class SetlistStatisticsService
{
    /**
     * Calculates top 5 most played songs which have been
     * played in one of out concerts.
     *
     * @param int|null $limit limits the number of query results. <code>Null</code>, if the
     *                        number of query results should not be limited. Default: <code>Null</code>
     * @return SetlistCountDto[]
     */
    public static function mostPlayed(?int $limit = null): array
    {
        return DB::table('setlist_entries')
            ->select(DB::raw('songs.id, songs.arranger, songs.title, count(setlist_entries.song_id) as count'))
            ->groupBy('songs.id', 'songs.arranger', 'songs.title')
            ->orderByDesc('count')
            ->join('songs', 'setlist_entries.song_id', '=', 'songs.id')
            ->limit($limit)
            ->get()
            ->map(fn ($value) => new SetlistCountDto(
                id: $value->id,
                arranger: $value->arranger,
                title: $value->title,
                count: $value->count))
            ->toArray();
    }
}
