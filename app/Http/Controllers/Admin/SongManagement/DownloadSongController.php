<?php

namespace App\Http\Controllers\Admin\SongManagement;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Models\Song;
use App\Services\Song\SongService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadSongController extends BaseAdminController
{
    public function __construct(
        protected SongService $service,
    ) {
        parent::__construct();
    }

    /**
     * Download the requested song file.
     */
    public function __invoke(Song $song, Request $request): StreamedResponse|JsonResponse
    {
        Log::debug('checking against Permission "download songs".');
        Gate::authorize('download songs');
        Log::debug('check successful');

        $file_path = $this->service->download($song);

        Log::info('Downloading the requested song located at path: '.$file_path);

        return Storage::download($file_path);
    }
}
