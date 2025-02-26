<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantSearchController extends Controller
{
    public function index()
    {
        return view('restaurants.search');
    }
}
