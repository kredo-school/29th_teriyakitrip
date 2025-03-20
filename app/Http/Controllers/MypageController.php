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
        $itineraries = $user->itineraries()->latest()->get(); // 旅程を取得
        $restaurantReviews = $user->reviews()->latest()->get();
        $topRestaurantReviews = $user->reviews()->latest()->limit(3)->get();

        foreach ($topRestaurantReviews as $review) {
            $review->restaurant_name = $this->getRestaurantNameFromGoogleAPI($review->place_id);
        }

        return view('mypage.index', compact('user', 'itineraries', 'restaurantReviews','topRestaurantReviews'));
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
        return asset('img/default-restaurant.jpg');
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

    public function show($tab = 'overview')
{
    $user = Auth::user();
    $itineraries = Itinerary::where('user_id', $user->id)->get();
    $restaurantReviews = RestaurantReview::where('user_id', $user->id)->get();
    // $followers = $user->followers()->paginate(20);
    // $following = $user->following()->paginate(20);

    // タブに応じて適切なビューを返す
    switch($tab) {
        case 'itineraries':
            return view('mypage.itineraries', compact('user', 'itineraries', 'tab'));
        case 'restaurant_reviews':
            return view('mypage.restaurant_reviews', compact('user', 'restaurantReviews', 'tab'));
        // case 'followers':
        //     // followers機能が実装されていない場合は、一時的にoverviewにリダイレクト
        //     return redirect()->route('mypage.show', 'followers');
        // case 'following':
        //     // following機能が実装されていない場合は、一時的にoverviewにリダイレクト
        //     return redirect()->route('mypage.show', 'following');
        default:
            return view('mypage.overview', compact('user', 'itineraries', 'restaurantReviews', 'tab'));
    
    }
}
}