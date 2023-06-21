<?php

namespace App\Http\Controllers\Admin\MusicianManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\MusicianRequest;
use App\Models\Musician;
use App\Services\Instrument\InstrumentService;
use App\Services\Musician\MusicianService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MusiciansController extends Controller
{
    public function __construct(
        public MusicianService $musicianService,
        public InstrumentService $instrumentService,
    ) {
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
        // $musician = $this->musicianService->create($request);
        $musician = Musician::create($this->getMusicianData($request));
        Log::info('Created a new musician', [$musician]);
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
                'instrument' => $this->instrumentService->fromMusician($musician)
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
                'instruments' => $this->instrumentService->all()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MusicianRequest $request, Musician $musician): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');
        // $this->musicianService->update($request, $musician);
        $musician->update($this->getMusicianData($request));
        Log::info('Updated musician', [$musician]);

        return redirect(route('musicians.show', $musician->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Musician $musician): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

        if ($musician->picture_filepath != null) {
            Log::info('Deleting picture of musician', [$musician]);
            Storage::delete($musician->picture_filepath);
        }
        Log::info('Deleting musician', [$musician]);
        $this->musicianService->delete($musician);

        return redirect(route('musicians.index'));
    }

    public function deletePicture(Musician $musician): RedirectResponse
    {
        Gate::authorize('manage musicians');

        Log::info('Deleting picture of musician after API call', [$musician]);
        if ($musician->picture_filepath != null) {
            Storage::delete($musician->picture_filepath);
        }
        $musician->update(['picture_filepath' => null]);

        return redirect(route('musicians.show', $musician->id));
    }

    private function getMusicianData(FormRequest $request): mixed
    {
        $data = $request->validated();
        Log::debug('validated data', [$data]);
        if ($request->file('picture') != null) {
            $picture_path = $request
                ->file('picture')
                ->store('musician_pictures', 'public');
            Log::debug('picture path:' . $picture_path);
            $data['picture_filepath'] = $picture_path;
        }
        return $data;
    }
}
