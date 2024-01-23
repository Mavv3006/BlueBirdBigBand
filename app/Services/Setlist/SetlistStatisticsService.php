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
     * @param int $limit limits the number of query results
     * @return SetlistCountDto[]
     */
    public static function mostPlayed(int $limit = 5): array
    {
        return DB::table('setlist_entries')
            ->select(DB::raw('count("song_id") as count, song_id'))
            ->groupBy('song_id')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(fn ($value) => new SetlistCountDto(
                song_id: $value->song_id,
                count: $value->count
            ))->toArray();
    }
}
