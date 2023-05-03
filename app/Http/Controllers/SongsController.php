<?php

namespace App\Http\Controllers;

use App\Models\Song;
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
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('manage songs');
        $songs = Song::select(['id', 'title', 'arranger', 'genre', 'author'])
            ->get();
        return Inertia::render('Admin/SongManagement/SongsIndex', ['songs' => $songs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/SongManagement/SongsCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        $data = $request->validate([
            'title' => 'string|required',
            'author' => 'string|required',
            'arranger' => 'string|required',
            'genre' => 'string|required',
            'file' => ['required', File::types(['audio/mpeg'])]
        ]);

        $file_path = $request->file('file')->store('songs', 'public');
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
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        Log::info('deleting song', [$song]);
        $song->delete();
        return redirect('admin/songs');
    }
}
