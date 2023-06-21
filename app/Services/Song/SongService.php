<?php

namespace App\Services\Song;

use App\Http\Requests\SongStoreRequest;
use App\Http\Requests\SongUpdateRequest;
use App\Models\Song;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Storage;

class SongService
{
    public function all(): Collection
    {
        return Song::select(['id', 'title', 'arranger', 'genre', 'author', 'file_path'])
            ->get();
    }

    public function update(SongUpdateRequest $request, Song $song): bool
    {
        return $song->update(
            $request->validated()
        );
    }

    public function store(SongStoreRequest $request): void
    {
        $data = $request->validated();

        $file = $request->file('file');

        $song = Song::create([
            'title' => $data['title'],
            'author' => $data['author'],
            'arranger' => $data['arranger'],
            'genre' => $data['genre'],
            'file_path' => $file->store('songs', 'public'),
            'size' => $file->getSize()
        ]);
        Log::info('Created a new song', [$song]);
    }

    public function destroy(Song $song): bool|null
    {
        Log::info('deleting song', [$song]);

        if (Storage::exists($song->file_path)) {
            Storage::delete($song->file_path);
        }
        return $song->delete();
    }
}
