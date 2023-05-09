<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMusicianRequest;
use App\Http\Requests\UpdateMusicianRequest;
use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MusiciansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Gate::authorize('manage musicians');

        $musicians = Musician::with('instrument')
            ->orderBy('instrument_id')
            ->get();
        Log::info('Showing all musicians', [$musicians]);
        return Inertia::render(
            'Admin/MusicianManagement/MusiciansIndex',
            ['data' => $musicians]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize('manage musicians');

        $instruments = Instrument::all();
        Log::info('Showing create musician form');
        return Inertia::render(
            'Admin/MusicianManagement/MusiciansCreate',
            ['instruments' => $instruments]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMusicianRequest $request): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

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

        $instrument = $musician->instrument()->first();
        Log::info('Showing musician', [$musician]);
        $musician_name = $musician->firstname . " " . $musician->lastname;
        $debug_message = 'The instrument of musician ' . $musician_name . ' (' . $musician->id . ')';
        Log::debug($debug_message, [$instrument]);
        return Inertia::render(
            'Admin/MusicianManagement/MusiciansShow',
            ['musician' => $musician, 'instrument' => $instrument]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Musician $musician): Response
    {
        Gate::authorize('manage musicians');

        $instruments = Instrument::all();
        Log::info('Editing musician', [$musician, $instruments]);
        return Inertia::render(
            'Admin/MusicianManagement/MusiciansEdit',
            ['musician' => $musician, 'instruments' => $instruments]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMusicianRequest $request, Musician $musician): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

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
        $musician->delete();

        return redirect(route('musicians.index'));
    }

    public function deletePicture(Musician $musician): RedirectResponse
    {
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
            Log::debug('picture path: ' . $picture_path);
            $data['picture_filepath'] = $picture_path;
        }
        return $data;
    }
}
