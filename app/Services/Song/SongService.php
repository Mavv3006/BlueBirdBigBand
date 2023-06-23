<?php

namespace App\Services\Song;

use App\Http\Requests\SongStoreRequest;
use App\Http\Requests\SongUpdateRequest;
use App\Models\Song;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    public function download(Song $song): string
    {
        Log::info("[SongService] Requesting to download song file", [$song]);
        $file_path = $song->file_path ?? "";
        Log::debug($file_path);
        if (!Storage::exists($file_path)) {
            Log::warning("[SongService] The file does not exist");
            return response()->json(['error' => "File not found"], status: 404);
        }

        Log::info('[SongService] The file does exist');
        return $file_path;
    }
}
