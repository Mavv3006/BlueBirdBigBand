<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadSongController extends Controller
{
    /**
     * Download the requested song file.
     */
    public function __invoke(Song $song, Request $request): StreamedResponse|JsonResponse
    {
        Gate::authorize('download songs');

        Log::debug('authenticated user', [Auth::user()]);
        Log::info("[DownloadSongController] Requesting to download song file", [$song]);
        $file_path = "" . $song->file_path;
        Log::debug($file_path);
        if (!Storage::exists($file_path)) {
            Log::warning("[DownloadSongController] The file does not exist");
            return response()->json(['error' => "File not found"], status: 404);
        }

        Log::info('[DownloadSongController] The file does exist');
        return Storage::download($file_path);
    }
}
