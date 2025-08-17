<?php

namespace App\Services\Song;

use App\Http\Requests\SongStoreRequest;
use App\Http\Requests\SongUpdateRequest;
use App\Models\Song;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SongService
{
    /** @returns Song[] */
    public function all(): array
    {
        return Song::select(['id', 'title', 'arranger', 'genre', 'author', 'file_path'])
            ->orderBy('title')
            ->get()
            ->toArray();
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
            'file_path' => $file->store('songs'),
            'size' => $file->getSize(),
        ]);
        Log::info('Created a new song', [$song]);
    }

    public function destroy(Song $song): ?bool
    {
        Log::info('deleting song', [$song]);

        if (Storage::exists($song->file_path)) {
            Storage::delete($song->file_path);
        }

        return $song->delete();
    }

    /**
     * @throws NotFoundHttpException if the requested file does not exist.
     */
    public function download(Song $song): string
    {
        Log::info('[SongService] Requesting to download song file', [$song]);
        $file_path = '/songs/'.$song->file_path ?? '';
        Log::debug($file_path);
        if (!Storage::exists($file_path)) {
            Log::warning('[SongService] The file does not exist');

            throw new NotFoundHttpException;
        }

        Log::info('[SongService] The file exists');

        return $file_path;
    }
}
