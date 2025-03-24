<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Itinerary;
use App\Models\RestaurantReview;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'overview'); // デフォルトは overview
        $user = Auth::user();
    
        $itineraries = collect();
        $restaurantReviews = collect();
        $topRestaurantReviews = collect();
        $topItineraries = collect(); // ← ここはOK
    
        if ($tab === 'itineraries') {
            $itineraries = $user->itineraries()->orderBy('start_date', 'asc')->get();
        } elseif ($tab === 'restaurant_reviews') {
            $restaurantReviews = $user->reviews()->latest()->get();
        } elseif ($tab === 'overview') {
            $topItineraries = $user->itineraries()->latest()->take(3)->get(); // ← 修正ポイント
            $topRestaurantReviews = $user->reviews()->latest()->take(3)->get();
    
            foreach ($topRestaurantReviews as $review) {
                $review->restaurant_name = $this->getRestaurantNameFromGoogleAPI($review->place_id);
            }
        }
    
        return view('mypage.index', [
            'user' => $user,
            'tab' => $tab,
            'itineraries' => $itineraries,
            'restaurantReviews' => $restaurantReviews,
            'topItineraries' => $topItineraries, // ← ここで使えるようになる
            'topRestaurantReviews' => $topRestaurantReviews,
        ]);
    }
    

    public function getRestaurantName(Request $request)
    {
        $place_id = $request->query('place_id');
        $apiKey = config('services.google.maps_api_key');

        if (!$place_id || !$apiKey) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=name&key={$apiKey}";
        $response = Http::get($apiUrl);

        return response()->json($response->json());
    }

    private function getRestaurantPhotoFromGoogleAPI($place_id)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}&language=en";

        $response = Http::get($apiUrl);
        $data = $response->json();

        if (isset($data['result']['photos'][0]['photo_reference'])) {
            $photoReference = $data['result']['photos'][0]['photo_reference'];
            return "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$photoReference}&key={$apiKey}";
        }

        return asset('img/default-restaurant.jpg');
    }

    private function getRestaurantNameFromGoogleAPI($place_id)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=name&key={$apiKey}";

        $response = Http::get($apiUrl);
        $data = $response->json();

        return $data['result']['name'] ?? 'Unknown Restaurant';
    }
}