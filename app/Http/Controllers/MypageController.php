<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Itinerary;
use App\Models\RestaurantReview;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class MypageController extends Controller
{

    public function index()
    {
        $user = auth()->user(); // ログイン中のユーザーを取得
        $itineraries = $user->itineraries()->where('is_public', 1)->latest()->limit(3)->get();
        $restaurantReviews = $user->reviews()->latest()->get();
        $topRestaurantReviews = $user->reviews()->latest()->limit(3)->get();
         // Itineraries タブ用の全件
        $allItineraries = $user->itineraries()->where('is_public', 1)->latest()->get();

        foreach ($topRestaurantReviews as $review) {
            $review->restaurant_name = RestaurantReview::where('place_id', $review->place_id)
            ->first()?->restaurant_name ?? 'Unknown Restaurant';
            // $review->restaurant_name = $this->getRestaurantNameFromGoogleAPI($review->place_id);
        }

        return view('mypage.index', compact('user', 'itineraries', 'restaurantReviews','allItineraries', 'topRestaurantReviews'));
    }

    public function showOtheruserspage($userId)
    {
        // 他のユーザーのデータを取得
        $user = User::findOrFail($userId);
        // Overview 用の最新3件
        $latestItineraries = $user->itineraries()->where('is_public', 1)->latest()->limit(3)->get();

        // Itineraries タブ用の全件
        $allItineraries = $user->itineraries()->where('is_public', 1)->latest()->get();


        $topRestaurantReviews = RestaurantReview::where('user_id', $userId)->latest()->take(3)->get();
        $restaurantReviews = RestaurantReview::where('user_id', $userId)->latest()->get();

        foreach ($topRestaurantReviews as $review) {
            $review->restaurant_name = RestaurantReview::where('place_id', $review->place_id)
            ->first()?->restaurant_name ?? 'Unknown Restaurant';
            // $review->restaurant_name = $this->getRestaurantNameFromGoogleAPI($review->place_id);
        }

        // 必要なデータをビューに渡す
        return view('mypage.show_others', compact('user','latestItineraries', 'allItineraries', 'topRestaurantReviews', 'restaurantReviews'));
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
    return Cache::remember("restaurant_photo_{$place_id}", now()->addHours(6), function () use ($place_id) {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}&language=en";

        $response = Http::get($apiUrl);
        $data = $response->json();

        // 🔥 `photo_reference` を取得
        if (isset($data['result']['photos'][0]['photo_reference'])) {
            $photoReference = $data['result']['photos'][0]['photo_reference'];
            return "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$photoReference}&key={$apiKey}";
        }

        // 🔥 写真がない場合のデフォルト画像
        return asset('images/restaurants/default-restaurant.jpg');
    });
}

private function getRestaurantNameFromGoogleAPI($place_id)
{
    return Cache::remember("restaurant_name_{$place_id}", now()->addHours(6), function () use ($place_id) {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$place_id}&fields=name&key={$apiKey}";

        $response = Http::get($apiUrl);
        $data = $response->json();

        return $data['result']['name'] ?? 'Unknown Restaurant';
    });
}

public function show($userId, $tab = 'overview')
{
    $user = User::findOrFail($userId); // ユーザーIDを使ってユーザーを取得
    $itineraries = Itinerary::where('user_id', $user->id)->get();
    $restaurantReviews = RestaurantReview::where('user_id', $user->id)->get();

    // タブに応じて適切なビューを返す
    switch($tab) {
        case 'itineraries':
            return view('mypage.itineraries', compact('user', 'itineraries', 'tab'));
        case 'restaurant_reviews':
            return view('mypage.restaurant_reviews', compact('user', 'restaurantReviews', 'tab'));
        default:
            return view('mypage.overview', compact('user', 'itineraries', 'restaurantReviews', 'tab'));
    }
}


}