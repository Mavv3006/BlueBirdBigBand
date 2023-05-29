<?php

namespace App\Http\Controllers\Admin\SongManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\SongRequest;
use App\Models\Song;
use App\Services\Song\SongService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;
use Inertia\Response;

class SongsController extends Controller
{
    public function __construct(
        public SongService $service,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('manage songs');
        $songs = Song::select(['id', 'title', 'arranger', 'genre', 'author', 'file_path'])
            ->get();
        return Inertia::render('Admin/SongManagement/SongsIndex', ['songs' => $songs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('manage songs');
        return Inertia::render('Admin/SongManagement/SongsCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage songs');

        $data = $request->validate([
            'title' => 'string|required',
            'author' => 'string|required',
            'arranger' => 'string|required',
            'genre' => 'string|required',
            'file' => ['required', File::types(['audio/mpeg'])]
        ]);

        $file_path = $request->file('file')->store('songs');
        $data['file_path'] = $file_path;

        $song = Song::create([
            'title' => $data['title'],
            'author' => $data['author'],
            'arranger' => $data['arranger'],
            'genre' => $data['genre'],
            'file_path' => $data['file_path'],
            'size' => $request->file('file')->getSize()
        ]);
        Log::info('Created a new song', [$song]);
        return redirect('admin/songs');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        Gate::authorize('manage songs');

        return Inertia::render(
            'Admin/SongManagement/SongsEdit',
            ['song' => $song]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SongRequest $request, Song $song)
    {
        Gate::authorize('manage songs');

        $this->service->update($request, $song);

        return redirect(route('songs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage songs');

        Log::info('deleting song', [$song]);
        $song->delete();
        return redirect('admin/songs');
    }
}
