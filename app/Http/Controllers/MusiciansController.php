<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMusicianRequest;
use App\Models\Instrument;
use App\Models\Musician;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\File;
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

        $data = $request->validated();
        Log::debug('validated data', [$data]);
        $musician = Musician::create($data);
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
    public function update(Request $request, Musician $musician): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

        $data = $request->validate([
            'firstname' => 'string|required',
            'lastname' => 'string|required',
            'instrument_id' => 'integer|required|min:0',
            'picture' => ['required', File::image()]
        ]);
        Log::debug('validated data', [$data]);
        $picture_path = $request->file('picture')->store('musician_pictures', 'public');
        Log::debug('picture path: ' . $picture_path);
        $data['picture_filepath'] = $picture_path;
        $musician->update($data);
        Log::info('Updated musician', [$musician]);
        return redirect(route('musicians.show', $musician->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Musician $musician): Redirector|RedirectResponse|Application
    {
        Gate::authorize('manage musicians');

        Log::info('Deleting musician', [$musician]);
        $musician->delete();
        return redirect(route('musicians.index'));
    }
}
