<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use Illuminate\Http\Request;
use App\Models\RestaurantReview;
use App\Models\FavoriteItinerary; //TOSHIMI
use App\Models\FavoriteRestaurant; //TOSHIMI
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $regions = [
            2 => 'Tohoku',
            3 => 'Kanto',
            4 => 'Tokai',
            5 => 'Hokuriku',
            6 => 'Kinki',
            7 => 'Chugoku',
            8 => 'Shikoku',
            9 => 'Kyushu'
        ];

        // 🔥 全エリアの口コミ件数が多いレストランを取得（place_idごとにカウント）
        $popularRestaurants = RestaurantReview::select(
            'place_id',
            DB::raw('COUNT(*) as review_count'),
            DB::raw('AVG(rating) as average_rate') // ⭐ 平均評価を計算
        )
            ->groupBy('place_id')
            ->orderByDesc('review_count') // 🔥 口コミ件数の多い順
            ->take(3) // 🔥 トップページには上位3つだけ表示
            ->get();


        // 🔥 Google API からレストランの情報（写真・名前）を取得
        foreach ($popularRestaurants as $restaurant) {
            $restaurant->restaurant_name = RestaurantReview::where('place_id', $restaurant->place_id)
            ->first()?->restaurant_name ?? 'Unknown Restaurant';
            //$restaurant->name = $this->getRestaurantNameFromGoogleAPI($restaurant->place_id);
            $restaurant->photo = $this->getRestaurantPhotoFromGoogleAPI($restaurant->place_id);
            $restaurant->average_rate = round($restaurant->average_rate, 1) ?? 0; // ⭐ 平均評価を四捨五入
            $favorite = FavoriteRestaurant::where('user_id', Auth::id())
                ->where('place_id', $restaurant->place_id)
                ->first();

            if ($favorite) {
                $restaurant->isFavorite = true;
            } else {
                $restaurant->isFavorite = false;
            }
        }



        // 🔥 各レストランの最新2レビューを取得
        $restaurantReviews = [];
        foreach ($popularRestaurants as $restaurant) {
            $reviews = RestaurantReview::where('place_id', $restaurant->place_id)
                ->latest()
                ->take(2) // 🔥 各レストランの最新2レビューのみ取得
                ->get();
            $restaurantReviews[$restaurant->place_id] = $reviews;
        }

        // 🔥 追加: getItineraries() を呼び出して取得 - SAKI
        $itineraries = $this->getItineraries();

        return view('home', compact('restaurantReviews', 'popularRestaurants', 'regions', 'itineraries'));
    }

    private function getRestaurantNameFromGoogleAPI($place_id)
    {
        return Cache::remember("restaurant_name_{$place_id}", now()->addHours(6), function () use ($place_id) {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}&language=en";

            $response = Http::get($apiUrl);
            $data = $response->json();

            return $data['result']['name'] ?? 'Unknown Restaurant';
        });
    }

    private function getRestaurantPhotoFromGoogleAPI($place_id)
    {
        return Cache::remember("restaurant_photo_{$place_id}", now()->addHours(6), function () use ($place_id) {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}&language=en";

            $response = Http::get($apiUrl);
            $data = $response->json();

            if (isset($data['result']['photos'][0]['photo_reference'])) {
                $photoReference = $data['result']['photos'][0]['photo_reference'];
                return "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$photoReference}&key={$apiKey}";
            }

            return asset('images/restaurants/default-restaurant.jpg');
        });
    }

    // 最新3件のitinerariesを取得
    public function getItineraries() // SAKI - to display lists of itineraries on toppage
    {
        $itineraries = Itinerary::where('is_public', true) // 公開されているものだけ
            ->orderBy('start_date', 'desc') // 開始日が新しい順
            ->take(3) // 最新3件のみ取得
            ->get();

        // 各Itineraryが現在のユーザーのお気に入りかどうかをチェック //TOSHIMI
        foreach ($itineraries as $itinerary) {
            $itinerary->is_favorite = FavoriteItinerary::where('user_id', Auth::id())
                                                        ->where('itinerary_id', $itinerary->id)
                                                        ->exists();
        }

        return $itineraries; // 🔥 ビューに渡すためのデータ
    }

    public function uploadItineraryImage(Request $request) // SAKI
    {
        // リクエストから画像ファイルを取得
        $image = $request->file('image');

        // ファイル名を作成（ここではユニークな名前をつけるためにタイムスタンプを使用）
        $filename = 'itinerary_' . time() . '.' . $image->getClientOriginalExtension();

        // ファイルを storage/app/public/itineraries に保存
        $path = $image->storeAs('public/itineraries', $filename);

        // 画像のパス（保存された場所）を取得
        $imagePath = 'itineraries/images' . $filename;

        return response()->json(['message' => 'Image uploaded successfully!']);
    }
}
