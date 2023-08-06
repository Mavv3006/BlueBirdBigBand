<?php

namespace App\Http\Controllers\Admin\SongManagement;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Services\Song\SongService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadSongController extends Controller
{

    public function __construct(
        protected SongService $service,
    )
    {
    }

    /**
     * Download the requested song file.
     */
    public function __invoke(Song $song, Request $request): StreamedResponse|JsonResponse
    {
        Log::info('checking against Permission "download songs".');
        Gate::authorize('download songs');
        Log::info('check successful');

        $file_path = $this->service->download($song);
        return Storage::download($file_path);
    }
}
