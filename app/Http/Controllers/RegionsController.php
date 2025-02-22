<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RegionsController extends Controller
{

    public function show()
    {
        return view('Regions.home', [
            'allItineraries' => [
                ['img' => 'biei_flower16.jpg', 'title' => '2025 Hokkaido Trip'],
                ['img' => 'OIP.jpg', 'title' => '2023 Hokkaido Trip'],
            ],
            'allRestaurants' => [
                ['img' => 'what-is-unagi.jpg', 'title' => 'ICHIBAN Unagi'],
                ['img' => 'download.jpg', 'title' => 'ABC Italian'],
            ]
        ]);
    }
}
