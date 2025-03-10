<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiProxyController extends Controller
{
    public function fetchPlaces(Request $request)
    {
        $query = $request->query('query'); // 検索キーワード
        $page = $request->query('page', 1); // デフォルトは1ページ目
        $perPage = 10; // 1ページあたりの表示件数　数字を変更しても20件ずつでるようになっている。


        if (!$query) {
            return response()->json(['error' => 'Query is required'], 400);
        }

        $apiKey = env('GOOGLE_MAPS_API_KEY'); // `.env` から API キーを取得
        $types = "restaurant|cafe|bar"; // レストラン・カフェ・バーのみ
        $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$query}&type={$types}&region=jp&language=en&key={$apiKey}";

        if ($page > 1) {
            $cachedToken = cache()->get("places_next_token_{$query}");
            if (!$cachedToken) {
                return response()->json(['error' => 'Next page token expired'], 400);
            }
            $url .= "&pagetoken={$cachedToken}";
        }

        // Google API へリクエスト
        $response = Http::get($url);
        $result = $response->json();

        if (!isset($result['results'])) {
            return response()->json(['error' => 'No results found'], 404);
        }

        $formattedResults = [];
        foreach ($result['results'] as $item) {
            $photoReference = $item['photos'][0]['photo_reference'] ?? null;
            $photoUrl = $photoReference ? $this->fetchPhotoUrl($photoReference) : "/images/restaurants/default-restaurant.jpg";

            $formattedResults[] = [
                'place_id' => $item['place_id'] ?? null,
                'formatted_address' => $item['formatted_address'] ?? 'Address not available',
                'name' => $item['name'] ?? 'No name',
                'photo' => $photoUrl,
            ];
        }

        // 次のページのトークンをキャッシュ（APIの制限により短時間のみ有効）
        if (isset($result['next_page_token'])) {
            cache()->put("places_next_token_{$query}", $result['next_page_token'], now()->addSeconds(180)); // 3分キャッシュ
        }

        // 総件数を計算
        $totalResults = count($formattedResults);
        $totalPages = ceil($totalResults / $perPage);

        return response()->json([
            'total' => count($formattedResults),
            'per_page' => $perPage,
            'current_page' => (int) $page,
            'total_pages' => $totalPages,
            'data' => $formattedResults,
        ], 200);
    }

    private function fetchPhotoUrl($photoReference)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        return "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$photoReference}&key={$apiKey}";
    }
}
