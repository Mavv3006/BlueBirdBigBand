<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMusicianRequest;
use App\Http\Requests\UpdateMusicianRequest;
use App\Models\Musician;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class MusiciansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $musicians = Musician::with('instrument')
            ->orderBy('instrument_id')
            ->orderBy('part')
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMusicianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Musician $musician): Response
    {
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
    public function edit(Musician $musician): Redirector|RedirectResponse|Application
    {
        Log::info('Editing musician', [$musician]);
        return redirect(route('musicians.show', $musician->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMusicianRequest $request, Musician $musician)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Musician $musician): Redirector|RedirectResponse|Application
    {
        Log::info('Deleting musician', [$musician]);
        $musician->delete();
        return redirect(route('musicians.index'));
    }
}
