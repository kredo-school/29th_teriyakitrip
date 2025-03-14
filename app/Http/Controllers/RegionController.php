<?php

namespace App\Http\Controllers;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use App\Models\RestaurantReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class RegionController extends Controller
{
    // 📌 Overviewページのデータ
    public function overview($prefecture_id)
{
    // 🔥 `prefecture_id` に基づいて `prefectures` テーブルから情報を取得
    $prefecture = Prefecture::findOrFail($prefecture_id);

    // 🔥 口コミ件数が多いレストランを取得（place_idごとにカウント）
    $popularRestaurants = RestaurantReview::select(
        'place_id', 
        DB::raw('COUNT(*) as review_count'), 
        DB::raw('AVG(rating) as average_rate') // ⭐ 平均評価を計算
    )
        ->where('prefecture_id', $prefecture_id)
        ->groupBy('place_id')
        ->orderByDesc('review_count')
        ->take(2)
        ->get();

    // 🔥 各 `place_id` について Google API からレストラン名を取得
    foreach ($popularRestaurants as $restaurant) {
        $restaurant->name = $this->getRestaurantNameFromGoogleAPI($restaurant->place_id);
        $restaurant->photo = $this->getRestaurantPhotoFromGoogleAPI($restaurant->place_id);
        $restaurant->average_rate = round($restaurant->average_rate, 1) ?? 0; // ⭐ 平均評価を四捨五入
    }

    // 🔥 上位の `place_id` に基づいて、最近の2レビューを取得
    $restaurantReviews = [];
    foreach ($popularRestaurants as $restaurant) {
        $reviews = RestaurantReview::where('place_id', $restaurant->place_id)
            ->latest()
            ->take(2)
            ->get();
        $restaurantReviews[$restaurant->place_id] = $reviews;
    }

    // 📌 ダミーデータを追加
    $allItineraries = [
        ['img' => 'biei_flower16.jpg', 'title' => '2025 Hokkaido Trip', 'description' => 'Enjoy the scenic beauty of Hokkaido.'],
        ['img' => 'OIP.jpg', 'title' => '2023 Hokkaido Trip', 'description' => 'Discover the hidden gems of Japan’s northern island.'],
        ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2022 Hokkaido Trip', 'description' => 'Snowy landscapes and warm hot springs.'],
        ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2021 Hokkaido Trip', 'description' => 'Experience the culture and cuisine of Hokkaido.'],
        ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2020 Hokkaido Trip', 'description' => 'A journey through Japan’s winter wonderland.']
    ];

    return view('regions.home', compact('prefecture', 'restaurantReviews', 'popularRestaurants','allItineraries'));
}


    // 📌 Restaurant Reviewページのデータ
    public function restaurantReview($prefecture_id)
    {
        // 🔥 `prefecture_id` に基づいて `prefectures` テーブルから情報を取得
        $prefecture = Prefecture::findOrFail($prefecture_id);

        // 🔥 `prefecture_id` に基づいて、その地域のレストランレビューを取得
        $allRestaurants = RestaurantReview::where('prefecture_id', $prefecture_id)
            ->select('place_id', DB::raw('AVG(rating) as average_rate')) // ⭐ 平均評価を計算
            ->groupBy('place_id') // ⭐ `place_id` ごとにグループ化
            ->get();

        foreach ($allRestaurants as $restaurant) {
            $restaurant->name = $this->getRestaurantNameFromGoogleAPI($restaurant->place_id);
            $restaurant->photo = $this->getRestaurantPhotoFromGoogleAPI($restaurant->place_id);
            $restaurant->average_rate = round($restaurant->average_rate, 1) ?? 0; // ⭐ 平均評価を四捨五入
        }

        // 🔥 `place_id` ごとに**すべてのレビュー**を取得
        $restaurantReviews = [];
        foreach ($allRestaurants as $restaurant) {
            $reviews = RestaurantReview::where('place_id', $restaurant->place_id)
                ->latest()
                ->take(2)
                ->get(); // 🔥 **すべてのレビューを取得**
            $restaurantReviews[$restaurant->place_id] = $reviews;
        }

        return view('regions.restaurant_review', compact('prefecture', 'restaurantReviews', 'allRestaurants'));
    }

    private function getRestaurantNameFromGoogleAPI($place_id)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}&language=en";

        $response = Http::get($apiUrl);
        $data = $response->json();

        return $data['result']['name'] ?? 'Unknown Restaurant'; // 🔥 レストラン名が取得できなかった場合のデフォルト
    }

    private function getRestaurantPhotoFromGoogleAPI($place_id)
{
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
}



    // 📌 Itineraryページのデータ
    public function itinerary($prefecture_id)
    {
        // 🔥 `prefecture_id` に基づいて `prefectures` テーブルから情報を取得
        $prefecture = Prefecture::findOrFail($prefecture_id);

        return view('Regions.itinerary', [
            'allItineraries' => [
                ['img' => 'biei_flower16.jpg', 'title' => '2025 Hokkaido Trip', 'description' => 'Enjoy the scenic beauty of Hokkaido.'],
                ['img' => 'OIP.jpg', 'title' => '2023 Hokkaido Trip', 'description' => 'Discover the hidden gems of Japan’s northern island.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2022 Hokkaido Trip', 'description' => 'Snowy landscapes and warm hot springs.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2021 Hokkaido Trip', 'description' => 'Experience the culture and cuisine of Hokkaido.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2020 Hokkaido Trip', 'description' => 'A journey through Japan’s winter wonderland.']
            ],
       'prefecture' => $prefecture // 🔥 ここで `prefecture` をビューに渡す
        ]);
    }

}