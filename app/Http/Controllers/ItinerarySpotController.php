<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Illuminate\Http\Request;
use App\Models\ItinerarySpot;
use App\Models\Itinerary; // 旅程モデル
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

    public function saveSpots(Request $request, $itineraryId)
    {
        \Log::info("🔍 受信データ:", $request->all()); // 🔍 デバッグログ追加
        $request->validate([
            'spots' => 'required|array|min:1',
            'spots.*.place_id' => 'required|string',
            'spots.*.spot_order' => 'required|integer',
            'spots.*.visit_time' => 'nullable|date_format:H:i',
            'spots.*.visit_day' => 'required|integer',
        ]);

        foreach ($validatedData['spots'] as $spot) {
            ItinerarySpot::create([
                'itinerary_id' => $itineraryId,
                'place_id' => $spot['place_id'],
                'order' => $spot['order'],
                'visit_time' => $spot['visit_time'] ?? null,
                'visit_day' => $spot['visit_day'],
            ]);
        }
    
        return response()->json(['message' => 'Spots saved successfully']);
    }

    private function fetchPlaceDetails($placeId)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $response = Http::get("https://maps.googleapis.com/maps/api/place/details/json", [
            'place_id' => $placeId,
            'key' => $apiKey,
            'fields' => 'name,formatted_address'
        ]);

        if ($response->successful() && isset($response['result'])) {
            return [
                'name' => $response['result']['name'] ?? 'Unknown Place',
                'address' => $response['result']['formatted_address'] ?? 'Unknown Address'
            ];
        }

        return null;
    }
}
