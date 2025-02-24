<?php

namespace App\Http\Controllers;

use App\Models\Regions;
use App\Models\Itineraries;
use Illuminate\Http\Request;

class ItinerariesController extends Controller
{
    private $itinerary;

    public function __construct(Itineraries $itinerary) {
        $this->itinerary = $itinerary;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Regions::with('prefectures')->get();

        return view('itineraries.itinerary_first_form', compact('regions'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Itineraries $itineraries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itineraries $itineraries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itineraries $itineraries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itineraries $itineraries)
    {
        //
    }
    public function index()
    {
        //
    }

    public function addList(){
        return view('itineraries.create_itinerary_header');
    }

    
}


