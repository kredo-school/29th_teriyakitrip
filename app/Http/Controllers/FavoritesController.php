<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteItinerary;
use App\Models\FavoriteRestaurant;
use App\Models\Itinerary;
use App\Models\RestaurantReview;

class FavoritesController extends Controller
{
    public function toggleFavoriteItinerary(Request $request, $itineraryId)
    {
        $user = Auth::user();
        $favorite = FavoriteItinerary::where('user_id', $user->id)
                                     ->where('itinerary_id', $itineraryId)
                                     ->first();

        if ($favorite) {
            $favorite->delete(); // すでにお気に入りなら削除
            return response()->json(['status' => 'removed']);
        } else {
            FavoriteItinerary::create([
                'user_id' => $user->id,
                'itinerary_id' => $itineraryId
            ]);
            return response()->json(['status' => 'added']);
        }
    }

    public function toggleFavoriteRestaurant(Request $request, $placeId)
    {
       
        $user = Auth::user();
        $favorite = FavoriteRestaurant::where('user_id', $user->id)
                                      ->where('place_id', $placeId)
                                      ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back();
            // return view('home', compact('restaurantReviews', 'popularRestaurants', 'regions'));
            // return response()->json(['status' => $favorite ? 'removed' : 'added']);
        } else {
            FavoriteRestaurant::create([
                'user_id' => $user->id,
                'place_id' => $placeId
            ]);
            return redirect()->back();
            // return view('home', compact('restaurantReviews', 'popularRestaurants', 'regions'));
            // return response()->json(['status' => $favorite ? 'removed' : 'added']);

        }
    }

    public function index()
    {
        //下記はdbにデータが入るようになったら使用。
        // $favoriteItineraries = FavoriteItinerary::where('user_id', Auth::id())
        //                                          ->with('itinerary')
        //                                          ->get();

        $favoriteRestaurants = FavoriteRestaurant::where('user_id', Auth::id())
                                                 ->with('restaurantReview')
                                                 ->get();

        return view('favorites.my_favorite', compact('favoriteRestaurants'));

        //下記は、dbにデータが入るようになったら使用。
        // return view('favorites.index', compact('favoriteItineraries' , 'favoriteRestaurants'));
    }
}
