<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    //
    public function create()
{
    return view('create_itinerary');
}

}
