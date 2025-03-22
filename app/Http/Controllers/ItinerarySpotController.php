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

    public function showSearchSpot($itinerary_id, $visit_day)
{
        // `visit_day` を `integer` に変換
        $visit_day = (int) $visit_day;

            // 旅程データを取得
    $itinerary = Itinerary::find($itinerary_id);
    if (!$itinerary) {
        abort(404, "Itinerary not found");
    }

        // `visit_day` に紐づくスポットを取得
        $spots = ItinerarySpot::where('itinerary_id', $itinerary_id)
                              ->where('visit_day', $visit_day)
                              ->orderBy('spot_order', 'asc')
                              ->get();
    
    return view('itineraries/create_add', compact('itinerary', 'visit_day'));
}

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

    public function saveItinerarySpots(Request $request, $id, $day)
    {
        $validatedData = $request->validate([
           'place_id' => 'required|string',
        ]);
    
        $visitDay = (int) $day;  
    
        $latestSpot = ItinerarySpot::where('itinerary_id', $id)
            ->where('visit_day', $visitDay)
            ->orderBy('spot_order', 'desc')
            ->first();
        $spotOrder = $latestSpot ? $latestSpot->spot_order + 1 : 1;
    
        ItinerarySpot::create([
            'itinerary_id' => $id,
            'place_id' => $validatedData['place_id'],
            'spot_order' => $spotOrder,
            'visit_time' => null,
            'visit_day' => $visitDay,
        ]);
    
        return redirect()->route('itineraries.create.body', ['id' => $id])
            ->with('success', 'Spot added successfully!');
    }
    

    public function deleteSpot($spotId)
{
    $spot = ItinerarySpot::findOrFail($spotId);
    $itineraryId = $spot->itinerary_id;
    $visitDay = $spot->visit_day;

    // ✅ スポット削除
    $spot->delete();

    // ✅ 削除後に `spot_order` を振り直す
    $spots = ItinerarySpot::where('itinerary_id', $itineraryId)
        ->where('visit_day', $visitDay)
        ->orderBy('spot_order')
        ->get();

    foreach ($spots as $index => $spot) {
        $spot->spot_order = $index + 1; // 1から順番を振り直す
        $spot->save();
    }

    return redirect("/create-itinerary/{$itineraryId}");
}

}
