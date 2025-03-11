<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItinerarySpot;
use App\Models\Itinerary;

class PlaceController extends Controller
{
    /**
     * 旅程にスポットを追加
     */
    public function store(Request $request)
    {
        $request->validate([
            'itinerary_id' => 'required|exists:itineraries,id',
            'place_id' => 'required|string',
            'visit_day' => 'required|integer',
            'visit_time' => 'nullable|date_format:H:i',
        ]);

        $spot = ItinerarySpot::create([
            'itinerary_id' => $request->itinerary_id,
            'place_id' => $request->place_id,
            'visit_day' => $request->visit_day,
            'visit_time' => $request->visit_time,
            'order' => ItinerarySpot::where('itinerary_id', $request->itinerary_id)->count() + 1
        ]);

        return response()->json([
            'message' => 'スポットが追加されました',
            'spot' => $spot
        ], 201);
    }

    /**
     * 旅程のスポットを削除
     */
    public function destroy($id)
    {
        $spot = ItinerarySpot::findOrFail($id);
        $spot->delete();

        return response()->json([
            'message' => 'スポットが削除されました'
        ], 200);
    }

   /**
     * Google Maps API から `place_id` の詳細を取得
     */
    public function getPlaceDetails(Request $request)
    {
        $request->validate([
            'place_id' => 'required|string'
        ]);

        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $placeId = $request->place_id;

        $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeId}&key={$apiKey}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['result'])) {
            return response()->json($data['result']);
        }

        return response()->json(['message' => '場所の詳細が取得できませんでした'], 404);
    }
}
