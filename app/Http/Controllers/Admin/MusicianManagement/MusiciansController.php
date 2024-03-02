<?php

namespace App\Http\Controllers\Admin\MusicianManagement;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Controllers\Controller;
use App\Http\Requests\MusicianRequest;
use App\Models\Musician;
use App\Services\Instrument\InstrumentService;
use App\Services\Musician\MusicianService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class MusiciansController extends BaseAdminController
{
    public function __construct(
        public MusicianService $musicianService,
        public InstrumentService $instrumentService,
    ) {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('manage musicians');

        return Inertia::render(
            'Admin/MusicianManagement/MusiciansIndex',
            ['data' => $this->musicianService->all()]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('manage musicians');

        return Inertia::render(
            'Admin/MusicianManagement/MusiciansCreate',
            ['instruments' => $this->instrumentService->all()]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MusicianRequest $request): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

        $musician = $this->musicianService->store($request);

        return redirect(route('musicians.show', $musician->id));
    }

    /**
     * Display the specified resource.
     */
    public function show(Musician $musician): Response
    {
        Gate::authorize('manage musicians');

        return Inertia::render(
            'Admin/MusicianManagement/MusiciansShow',
            [
                'musician' => $musician,
                'instrument' => $this->instrumentService->fromMusician($musician),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Musician $musician): Response
    {
        Gate::authorize('manage musicians');

        return Inertia::render(
            'Admin/MusicianManagement/MusiciansEdit',
            [
                'musician' => $musician,
                'instruments' => $this->instrumentService->all(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MusicianRequest $request, Musician $musician): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

        $this->musicianService->update($request, $musician);

        return redirect(route('musicians.show', $musician->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Musician $musician): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

        $this->musicianService->delete($musician);

        return redirect(route('musicians.index'));
    }

    public function deletePicture(Musician $musician): RedirectResponse
    {
        Gate::authorize('manage musicians');

        $this->musicianService->deletePicture($musician);

        return redirect(route('musicians.show', $musician->id));
    }
}
