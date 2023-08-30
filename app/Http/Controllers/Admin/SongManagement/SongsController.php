<?php

namespace App\Http\Controllers\Admin\SongManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\SongStoreRequest;
use App\Http\Requests\SongUpdateRequest;
use App\Models\Song;
use App\Services\Song\SongService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
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

        return Inertia::render(
            'Admin/SongManagement/SongsIndex',
            ['songs' => $this->service->all()]
        );
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
    public function store(SongStoreRequest $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage songs');

        $this->service->store($request);

        return redirect(route('songs.index'));
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
    public function update(SongUpdateRequest $request, Song $song)
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

        $this->service->destroy($song);

        return redirect('admin/songs');
    }
}
