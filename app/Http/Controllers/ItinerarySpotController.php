<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Illuminate\Http\Request;
use App\Models\ItinerarySpot;
use App\Models\Itinerary; // 旅程モデル
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
 // 都道府県モデル

class ItinerarySpotController extends Controller {

    /**
     * Google Maps APIを使用して都道府県ごとのスポットを取得
     */
    public function search(Request $request)
    {
        // 🌟 `itinerary_id` を取得
        $itineraryId = $request->input('itinerary_id');

        // 🌟 旅程に紐づく `prefecture` を取得
        $itinerary = Itinerary::with('prefectures')->find($itineraryId);

        if (!$itinerary) {
            return response()->json(['error' => '旅程が見つかりません'], 404);
        }

        // 🌟 検索する都道府県リストを作成
        $prefectureNames = $itinerary->prefectures->pluck('name')->toArray();

        // 🌟 Google Places API でデータを取得
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $searchResults = [];

        foreach ($prefectureNames as $prefecture) {
            $query = $prefecture . " tourist attractions";
            $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . urlencode($query) . "&key=" . $apiKey;

            $response = Http::get($url);
            $data = $response->json();

            if (isset($data['results'])) {
                $searchResults[$prefecture] = $data['results'];
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $searchResults,
        ]);
    }

    public function saveItinerarySpots(Request $request, $itineraryId)
    {
        dd($request->all()); // デバッグ用: 送信データを確認する
        Log::info("🔍 受信データ(raw):", $request->all()); // 🔍 デバッグログ追加

        $validatedData =  $request->validate([
            'spots' => 'required|array|min:1',
            'spots.*.place_id' => 'required|string',
            'spots.*.spot_order' => 'required|integer',
            'spots.*.visit_time' => 'nullable|date_format:H:i',
            'spots.*.visit_day' => 'required|integer',
        ]);

        Log::info("✅ バリデーション通過データ:", $validatedData);


        foreach ($validatedData['spots'] as $spot) {
    
                
            ItinerarySpot::create([
                'itinerary_id' => $itineraryId,
                'place_id' => $spot['place_id'],
                'order' => $spot['spot_order'],
                'visit_time' => $spot['visit_time'] ?? null,
                'visit_day' => $spot['visit_day'],
            ]);
        }
    
        return response()->json([
            'message' => 'Spots saved successfully',
            'redirect_url' => route('home') 
        ]);
    }

    // private function fetchPlaceDetails($placeId)
    // {
    //     $apiKey = env('GOOGLE_MAPS_API_KEY');
    //     $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$placeId}&fields=name,formatted_address&key={$apiKey}";
    //     $response = Http::get($url);
    //     $data = $response->json();

    //     if ($response->successful() && isset($data['result'])) {
    //         return [
    //             'name' => $data['result']['name'] ?? 'Unknown Place',
    //             'address' => $data['result']['formatted_address'] ?? 'Unknown Address'
    //         ];
    //     }

    //     return null;
    // }
}
