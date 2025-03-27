<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Region;
use App\Models\Prefecture;
use Illuminate\Http\Request;
use App\Models\ItinerarySpot;
use App\Models\Itinerary; // 旅程モデル
use Illuminate\Support\Facades\DB;
use App\Models\ItineraryPrefecture;
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
    
    return view('itineraries/create_spots_add', compact('itinerary', 'visit_day'));
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
        Log::info('🔥 saveItinerarySpots() が呼ばれました', [
            'itinerary_id' => $id,
            'visit_day' => $day,
            'request_data' => $request->all()
        ]);
    
        try {
            DB::beginTransaction();
    
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
    
            DB::commit();
    
            Log::info('✅ スポットが保存されました', [
                'itinerary_id' => $id,
                'place_id' => $validatedData['place_id'],
                'visit_day' => $visitDay,
                'spot_order' => $spotOrder
            ]);
    
            return redirect()->route('itineraries.showSpots', ['id' => $id]);

    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ スポット保存エラー', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'スポット保存に失敗しました');
        }
    }

    //from backend part 3
    // public function saveItinerarySpots(Request $request, $itineraryId)
    // {
    //     dd($request->all()); // デバッグ用: 送信データを確認する
    //     Log::info("🔍 受信データ(raw):", $request->all()); // 🔍 デバッグログ追加

    //     $validatedData =  $request->validate([
    //         'spots' => 'required|array|min:1',
    //         'spots.*.place_id' => 'required|string',
    //         'spots.*.spot_order' => 'required|integer',
    //         'spots.*.visit_time' => 'nullable|date_format:H:i',
    //         'spots.*.visit_day' => 'required|integer',
    //     ]);

    //     Log::info("✅ バリデーション通過データ:", $validatedData);


    //     foreach ($validatedData['spots'] as $spot) {
    
                
    //         ItinerarySpot::create([
    //             'itinerary_id' => $itineraryId,
    //             'place_id' => $spot['place_id'],
    //             'order' => $spot['spot_order'],
    //             'visit_time' => $spot['visit_time'] ?? null,
    //             'visit_day' => $spot['visit_day'],
    //         ]);
    //     }
    
    //     return response()->json([
    //         'message' => 'Spots saved successfully',
    //         'redirect_url' => route('home') 
    //     ]);
    // }

    public function showSpots($itineraryId) {
        // 旅程情報を取得
        $itinerary = Itinerary::findOrFail($itineraryId);
    
        // スポット情報を取得（visit_day ごとにグループ化）
        $spots = ItinerarySpot::where('itinerary_id', $itineraryId)
            ->orderBy('visit_day')
            ->orderBy('spot_order')
            ->get()
            ->groupBy('visit_day');
    
        // 都道府県から地域を取得
        $prefectureIds = ItineraryPrefecture::where('itinerary_id', $itineraryId)
            ->pluck('prefecture_id');
    
        $regions = Region::whereIn('id', function ($query) use ($prefectureIds) {
            $query->select('region_id')->from('prefectures')->whereIn('id', $prefectureIds);
        })->get();

            // `$daysList` を作成
        $daysCount = Carbon::parse($itinerary->start_date)->diffInDays(Carbon::parse($itinerary->end_date)) + 1;
        $daysList = range(1, $daysCount);

    
        // ✅ `$itineraryId` を明示的に渡す
        return view('itineraries.create_itinerary_show_spot', compact('itinerary', 'itineraryId', 'daysList', 'spots', 'regions'));
    }
    
    
    
    // public function showSpots($id) {
    //     $itinerary = Itinerary::find($id);
    //     if (!$itinerary) {
    //         abort(404, "Itinerary not found");
    //     }
    
    //     // 🔥 `spots` だけを取得して渡す
    //     $spots = ItinerarySpot::where('itinerary_id', $id)
    //         ->orderBy('visit_day')
    //         ->orderBy('spot_order')
    //         ->get();
    
    //     // $daysList = implode(',', $daysListArray); // 🔥 `$daysListArray` を `string` に変換
    
    //     // // 🔥 `itinerary_prefectures` から `prefecture_id` を取得
    //     // $prefectureIds = ItineraryPrefecture::where('itinerary_id', $id)->pluck('prefecture_id');
    
    //     // // 🔥 `prefectures` から `region_id` を取得し、それを `regions` から取得
    //     // $regions = Region::whereIn('id', function ($query) use ($prefectureIds) {
    //     //     $query->select('region_id')
    //     //           ->from('prefectures')
    //     //           ->whereIn('id', $prefectureIds);
    //     // })->get();
    
    //     // // 🔥 スポット情報を取得
    //     // $spots = ItinerarySpot::where('itinerary_id', $id)
    //     //     ->orderBy('visit_day')
    //     //     ->orderBy('spot_order')
    //     //     ->get()
    //     //     ->groupBy('visit_day'); // `visit_day` ごとにグループ化
    
    //     return view('itineraries.create_itinerary_show_spot', compact('itinerary', 'spots'));
    // }
    
    
      
    

    public function deleteSpotsByDay($id, $visitDay) {
        try {
            ItinerarySpot::where('itinerary_id', $id)
                ->where('visit_day', $visitDay)
                ->delete();
    
            return response()->json([
                "success" => true,
                "message" => "Day $visitDay のスポットを一括削除しました"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "スポット削除に失敗しました",
                "error" => $e->getMessage()
            ], 500);
        }
    }
      
//     public function getSpotsByItinerary($id)
// {
//     $spots = ItinerarySpot::where('itinerary_id', $id)
//         ->orderBy('visit_day')
//         ->orderBy('spot_order')
//         ->get();

//     return response()->json($spots);
// }

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
