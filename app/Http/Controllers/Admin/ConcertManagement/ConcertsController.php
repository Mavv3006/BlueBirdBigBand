<?php

namespace App\Http\Controllers\Admin\ConcertManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConcertRequest;
use App\Http\Requests\UpdateConcertRequest;
use App\Models\Concert;
use App\Services\Concert\ConcertService;
use App\Services\Venue\VenueService;
use Inertia\Inertia;
use Inertia\Response;

class ConcertsController extends Controller
{
    public function __construct(
        protected ConcertService $concertService,
        protected VenueService   $venueService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/ConcertManagement/ConcertsCreate', [
            'venues' => $this->venueService->all(),
            'bands' => $this->concertService->allBands()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConcertRequest $request)
    {
        $data = $request->validated();
        $concertDto = $this->concertService->createDto($data);
        $concert = $this->concertService->store($concertDto);
        return redirect()->route('concerts.show', $concert->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Concert $concert)
    {
        return Inertia::render('Admin/ConcertManagement/ConcertsShow', [
            'concert' => $this->concertService->formatConcert($concert)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Concert $concert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConcertRequest $request, Concert $concert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Concert $concert)
    {
        //
    }
}
