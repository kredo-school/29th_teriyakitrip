<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GooglePlaceController extends Controller
{
    /**
     * Google Places APIを使ってスポットを検索する
     */
    public function search(Request $request)
    {
        // 🔍 受け取ったクエリをログに記録
        Log::info("🔍 受け取った検索クエリ: " . $request->input('query'));
    
        // 🔹 クエリパラメータ（検索ワード）を取得
        $query = $request->input('query');
    
        if (!$query) {
            Log::error("❌ 検索ワードが提供されていません！");
            return response()->json(['error' => '検索ワードが必要です'], 400);
        }
    
        // 🔹 Google Places API のエンドポイント
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        // 🔍 APIキーをログに記録
        Log::info("🔍 取得した API キー: " . ($apiKey ? 'EXISTS' : 'MISSING'));
    
        if (!$apiKey) {
            Log::error("❌ Google APIキーが取得できません！");
            return response()->json(['error' => 'Google APIキーが設定されていません'], 500);
        }
    
        // 🔹 Google Places API のリクエストURLを正しく構築
        $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . urlencode($query) . "&key=" . $apiKey;

        // 🔍 ログに記録してURLをデバッグ
        Log::info("🔍 Google APIリクエストURL: " . $url);
    
        // 🔹 API リクエストを送信
        $response = Http::get($url);
        $data = $response->json();
    
        // 🔍 Google APIのレスポンスをログに記録
        Log::info("✅ Google APIレスポンス: ", $data);
    
        // 🔹 `REQUEST_DENIED` などのエラーをチェック
        if ($response->failed() || isset($data['status']) && $data['status'] !== "OK") {
            Log::error("❌ Google APIエラー: " . ($data['error_message'] ?? '不明なエラー'), ['status' => $data['status']]);
            return response()->json(['error' => $data['error_message'] ?? 'Google API から適切なデータを取得できませんでした'], 500);
        }

        if (isset($data['status']) && $data['status'] === "REQUEST_DENIED") {
            Log::error("❌ Google API エラー: " . ($data['error_message'] ?? '不明なエラー'));
            return response()->json(['error' => $data['error_message'] ?? 'Google APIエラー'], 500);
        }
    
    
        // // 🔹 `results` が存在しない場合は `{results: []}` を返す
        // if (empty($data['results'])) {
        //     return response()->json(['results' => []]);
        // }
    
        // // 🔹 必要な情報だけを整形
        // $places = collect($data['results'])->map(function ($place) use ($apiKey) {
        //     return [
        //         'place_id' => $place['place_id'],
        //         'name' => $place['name'],
        //         'address' => $place['formatted_address'] ?? '住所情報なし',
        //         'lat' => $place['geometry']['location']['lat'],
        //         'lng' => $place['geometry']['location']['lng'],
        //         'photo' => isset($place['photos'][0]) 
        //             ? "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=" . $place['photos'][0]['photo_reference'] . "&key=" . $apiKey
        //             : asset('images/default.png'),
        //     ];
        // });
        return response()->json($data);
        // 🔹 JSON でレスポンスを返す
        // return response()->json(['results' => $places]);
    }
    
    
    public function getSpotDetails($placeId)
{
    if (!$placeId) {
        return response()->json(['error' => 'place_id が必要です'], 400);
    }

    $apiKey = env('GOOGLE_MAPS_API_KEY');
    $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$placeId}&key={$apiKey}";

    $response = Http::get($url);
        $data = $response->json();

    if (!$response->ok()) {
        return response()->json(['error' => 'Google API リクエスト失敗'], 500);
    }

    if (!isset($data['result'])) {
        return response()->json(['error' => 'スポットの詳細情報が取得できませんでした'], 500);
    }

    return response()->json($data['result']);
}

}
