<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Itinerary;
use Illuminate\Support\Facades\Auth;

class MyItineraryController extends Controller
{

    public function index() //Toshimi
    {
        return view('itinerary.index');
    }
}
