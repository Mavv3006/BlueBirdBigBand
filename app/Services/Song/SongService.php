<?php

namespace App\Services\Song;

use App\Models\Song;
use Illuminate\Database\Eloquent\Collection;

class SongService
{

    public function all(): Collection
    {
        return Song::select(['id', 'title', 'arranger', 'genre', 'author', 'file_path'])
            ->get();
    }
}
