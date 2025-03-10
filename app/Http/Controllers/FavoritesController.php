<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        // 🌟 ダミーデータ（Itineraries）
        $favoriteItineraries = [
            ['id' => 1, 'title' => '2025 Okinawa Trip', 'image' => 'images/sample2.jpg', 'user' => 'Toshimi'],
            ['id' => 2, 'title' => '2019 Hokkaido Trip', 'image' => 'images/sample3.jpg', 'user' => 'Yuki'],
            ['id' => 3, 'title' => '2025 Miyazaki Trip', 'image' => 'images/sample4.jpg', 'user' => 'Naoki'],
        ];

        // 🌟 ダミーデータ（Restaurant Reviews）
        $favoriteRestaurants = [
            ['id' => 1, 'restaurant' => 'Sushi Place', 'image' => 'images/sample5.jpg', 'rating' => 4, 'review' => 'Amazing sushi!'],
            ['id' => 2, 'restaurant' => 'Ramen House', 'image' => 'images/sample6.jpg', 'rating' => 5, 'review' => 'Best ramen ever!'],
            ['id' => 3, 'restaurant' => 'Cafe Mocha', 'image' => 'images/sample7.jpg', 'rating' => 3, 'review' => 'Cozy atmosphere.'],
        ];

        return view('favorites.my_favorite', compact('favoriteItineraries', 'favoriteRestaurants'));
    }

    //Nahoさんのコードが完成したらfavorite機能を付け足す
    // public function unfavorite(Request $request, $id) {
    //     return redirect()->route('favorites.list')->with('success', 'Itinerary removed from favorites.');
    // }
    
}
