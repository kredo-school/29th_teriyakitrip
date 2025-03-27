<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Illuminate\Http\Request;
use App\Models\RestaurantReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\RestaurantReviewPhoto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class RestaurantReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurantReviews = RestaurantReview::latest()->paginate(10);
        return view('restaurant_reviews.index', compact('restaurantReviews'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $place_id = $request->query('place_id'); // クエリパラメータから取得
        $photoUrl = $request->query('photo'); // 検索結果の画像URLを取得
        if (!$place_id) {
            return redirect()->back()->with('error', 'Invalid restaurant selection.');
        }
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}";
        $response = Http::get($apiUrl);
        $data = $response->json();
        if (!isset($data['result'])) {
            return redirect()->back()->with('error', 'Restaurant details not found.');
        }
        // もし検索結果から画像が渡っていれば、それを使用（検索結果と統一）
        $photo = $photoUrl ?? (isset($data['result']['photos'][0]['photo_reference'])
            ? "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$data['result']['photos'][0]['photo_reference']}&key={$apiKey}"
            : "/images/restaurants/default-restaurant.jpg"
        );
        // 必要な情報を取得
        $restaurant = [
            'place_id' => $place_id,
            'name' => $data['result']['name'] ?? 'Unknown Restaurant',
            'photo' => $photo
        ];
        // :fire: API のレスポンスを確認
        // dd($data);
        return view('reviews.create', compact('restaurant'));
    }

    // I will code later when I need to make Backend part
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'place_id' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1048', // 画像のみ、1MB以内
        ]);
        // :fire: Google API から都道府県を取得
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$request->place_id}&key={$apiKey}&language=en";
        $response = Http::get($apiUrl);
        $data = $response->json();
        $prefectureName = null;
        if (isset($data['result']['address_components'])) {
            foreach ($data['result']['address_components'] as $component) {
                if (in_array('administrative_area_level_1', $component['types'])) {
                    $prefectureName = $component['long_name']; // 例: "Tokyo"
                    break;
                }
            }
        }

        // 🔥 `prefectures` テーブルから `prefecture_id` を取得
        $prefecture = Prefecture::where('name', $prefectureName)->first();
        $prefectureId = $prefecture ? $prefecture->id : null;
        $mainPhotoPath = null; // メイン画像のパス
        // 画像がアップロードされた場合
        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            if (count($photos) > 0) {
                // :fire: 最初の画像をメイン画像として `restaurant_reviews` に保存
                $mainPhotoPath = $photos[0]->store('reviews', 'public');
            }
        }
        $restaurantName = $this->getRestaurantNameFromGoogleAPI($request->place_id);
        // `restaurant_reviews` テーブルにレビューを保存
        $review = RestaurantReview::create([
            'user_id' => auth()->id(), // 現在のユーザーID
            'place_id' => $request->place_id, // Google APIの place_id
            'prefecture_id' => $prefectureId, // :fire: `prefecture_id` を保存
            'restaurant_name' => $restaurantName, // 🔥 Google APIから取得した名前を保存！
            'rating' => $request->rating,
            'title' => $request->title,
            'body' => $request->body,
            'photo' => $mainPhotoPath,
        ]);
        // 画像がアップロードされた場合、`restaurant_review_photos` に保存
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // 画像を `storage/app/public/reviews` に保存
                $photoPath = $photo->store('reviews', 'public');
                // `restaurant_review_photos` に画像パスを保存
                RestaurantReviewPhoto::create([
                    'restaurant_review_id' => $review->id,
                    'photo' => $photoPath,
                ]);
            }
        }
        return redirect()->route('reviews.show', [
            'place_id' => $review->place_id,
            'photo' => urlencode($review->photo)
        ]);
    }
    /**
     * Display the specified resource.
     */

    
    public function show(Request $request)
    {
        $place_id = $request->query('place_id'); // クエリパラメータから取得
        $photoUrl = $request->query('photo'); // 検索結果の画像URLを取得

        if (!$place_id) {
            return redirect()->back()->with('error', 'Invalid restaurant selection.');
        }

        // 🔥 キャッシュを利用してレストラン情報を取得
        $restaurant = Cache::remember("restaurant_details_{$place_id}", now()->addHours(6), function () use ($place_id) {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}";

            $response = Http::get($apiUrl);
            $data = $response->json();

            if (!isset($data['result'])) {
                return [
                    'place_id' => $place_id,
                    'name' => 'Unknown Restaurant',
                    'photos' => [],
                    'photo' => "/images/restaurants/default-restaurant.jpg",
                    'price_level' => null,
                    'address' => 'No address available',
                    'phone' => 'N/A',
                    'website' => '#',
                    'lat' => null,
                    'lng' => null,
                    'opening_hours' => [],
                ];
            }

            $photos = [];
            if (isset($data['result']['photos'])) {
                foreach (array_slice($data['result']['photos'], 0, 3) as $photo) {
                    $photos[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={$photo['photo_reference']}&key={$apiKey}";
                }
            }

            return [
                'place_id' => $place_id,
                'name' => $data['result']['name'] ?? 'Unknown Restaurant',
                'photos' => $photos,
                'photo' => isset($data['result']['photos'][0]['photo_reference']) 
                    ? "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$data['result']['photos'][0]['photo_reference']}&key={$apiKey}"
                    : "/images/restaurants/default-restaurant.jpg",
                'price_level' => $data['result']['price_level'] ?? null,
                'address' => $data['result']['formatted_address'] ?? 'No address available',
                'phone' => $data['result']['formatted_phone_number'] ?? 'N/A',
                'website' => $data['result']['website'] ?? '#',
                'lat' => $data['result']['geometry']['location']['lat'] ?? null,
                'lng' => $data['result']['geometry']['location']['lng'] ?? null,
                'opening_hours' => $data['result']['opening_hours']['weekday_text'] ?? [],
            ];
        });
        

        // レビュー情報を取得（キャッシュは不要）
        $reviews = RestaurantReview::where('place_id', $place_id)->latest()->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        $reviewCount = $reviews->count();

        return view('reviews.show', compact('restaurant', 'reviews', 'averageRating', 'reviewCount'));
    }

    public function getRestaurantNameFromGoogleAPI($place_id)
    {
        return Cache::remember("restaurant_name_{$place_id}", now()->addHours(6), function () use ($place_id) {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$place_id}&key={$apiKey}&language=ja";
            $response = Http::get($apiUrl);
            $data = $response->json();
            return $data['result']['name'] ?? 'Unknown Restaurant';
        });
    }


    // SAKI - show my restaurant review page
    public function viewMyreview($id) {
        // 現在のユーザーのレビューを取得（間違ったIDのレビューを取得しないようにする）
        $review = RestaurantReview::where('id', $id)
            ->where('user_id', auth()->id()) // ログインユーザーのレビューのみ
            ->with('photos') // 関連する写真を取得
            ->firstOrFail();

        // Google API からレストランの詳細情報を取得
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $placeId = $review->place_id; // レビューに紐づくレストランのplace_id
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeId}&key={$apiKey}";

        // APIリクエストを送信
        $response = Http::get($apiUrl);
        $data = $response->json();

        // デバッグ用: APIレスポンスを確認
        if (!isset($data['result'])) {
            return back()->with('error', 'レストラン情報を取得できませんでした。');
        }

        // レストラン画像の取得
        if (isset($data['result']['photos'][0]['photo_reference'])) {
            $photoReference = $data['result']['photos'][0]['photo_reference'];
            $photo = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$photoReference}&key={$apiKey}";
        } else {
            $photo = asset('/images/restaurants/default-restaurant.jpg'); // デフォルト画像
        }

        // レストラン情報を格納
        $restaurant = [
            'place_id' => $placeId,
            'name' => $data['result']['name'] ?? 'Unknown Restaurant',
            'photo' => $photo,
            'address' => $data['result']['formatted_address'] ?? 'No address available',
        ];

        // レビューに紐づく写真を取得
        $photos = $review->photos;

        // `view_myreview` にデータを渡して表示
        return view('reviews.view_myreview', compact('restaurant', 'review', 'photos'));
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantReview $review)
    {
        // 現在のレビューに関連するレストラン情報を取得
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $placeId = $review->place_id;
        $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeId}&key={$apiKey}";
        $response = Http::get($apiUrl);
        $data = $response->json();

        if (!isset($data['result'])) {
            return back()->with('error', 'レストラン情報を取得できませんでした。');
        }

        // レストランの情報を格納
        $restaurant = [
            'place_id' => $placeId,
            'name' => $data['result']['name'] ?? 'Unknown Restaurant',
            'photo' => isset($data['result']['photos'][0]['photo_reference']) ?
                    "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference={$data['result']['photos'][0]['photo_reference']}&key={$apiKey}" : 
                    '/images/restaurants/default-restaurant.jpg',
        ];

        // レビューに関連する写真を取得
        $photos = $review->photos;

        return view('reviews.edit_myreview', compact('review', 'restaurant', 'photos'));
    }

    public function update(Request $request, $id)
{
    try {
        DB::beginTransaction(); // トランザクション開始

        $review = RestaurantReview::findOrFail($id);

        // レビューの更新
        $review->update([
            'rating' => $request->input('rating'),
            'title'  => $request->input('title'),
            'body'   => $request->input('body'),
        ]);

        // 既存の写真のカウント
        $existingPhotoCount = $review->photos()->count();

        // 🟢 【ここに写真処理を追加する！】
        if ($request->hasFile('photos')) {
            $newPhotos = $request->file('photos', []);
            Log::info('Uploaded photos:', ['photos' => $newPhotos]);

            $totalPhotos = $existingPhotoCount + count($newPhotos);

            // 6枚を超えた場合の処理
            if ($totalPhotos > 6) {
                return redirect()->back()->with('error', 'You can upload up to 6 images only.');
            }

            $photoData = [];

            foreach ($newPhotos as $photo) {
                Log::info('Processing photo:', ['photo' => $photo->getClientOriginalName()]);

                $path = $photo->storeAs('reviews', $photo->hashName(), 'public');
                Log::info('Photo saved to: ' . $path);

                $photoData[] = [
                    'restaurant_review_id' => $review->id,
                    'photo' => str_replace('public/', '', $path),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($photoData)) {
                RestaurantReviewPhoto::insert($photoData);
            }
        }

        // 新たに追加された写真があれば処理する
        if ($request->hasFile('additional_photos')) {
            $additionalPhotos = $request->file('additional_photos', []);
            Log::info('Additional uploaded photos:', ['photos' => $additionalPhotos]);

            $totalPhotos = $existingPhotoCount + count($additionalPhotos);

            // 6枚を超えた場合の処理
            if ($totalPhotos > 6) {
                return redirect()->back()->with('error', 'You can upload up to 6 images only.');
            }

            $additionalPhotoData = [];

            foreach ($additionalPhotos as $photo) {
                Log::info('Processing additional photo:', ['photo' => $photo->getClientOriginalName()]);

                $path = $photo->storeAs('reviews', $photo->hashName(), 'public');
                Log::info('Additional photo saved to: ' . $path);

                $additionalPhotoData[] = [
                    'restaurant_review_id' => $review->id,
                    'photo' => str_replace('public/', '', $path),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($additionalPhotoData)) {
                RestaurantReviewPhoto::insert($additionalPhotoData);
            }
        }

        DB::commit(); // トランザクションを確定

        return redirect()->route('reviews.view_myreview', $review->id);
    } catch (\Exception $e) {
        DB::rollBack(); // 失敗時はロールバック
        Log::error('Error starts here');
        Log::error($e->getMessage());
        Log::error('Error ends here');
        return redirect()->back()->with('error', 'An error occurred while updating the review.');
    }
}


    public function deletePhoto($photoId)
    {
        try {
            // restaurant_review_photos テーブルを扱うモデルを使う
            $photo = RestaurantReviewPhoto::findOrFail($photoId);
            
            // ストレージから削除
            Storage::delete('public/' . $photo->photo);
            
            // データベースから削除
            $photo->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = RestaurantReview::findOrFail($id);
        $review->delete();

        return back()->with('success', 'レビューを削除しました。');
    }

    public function search(Request $request)
    {
        $type = $request->input('type');
        $keyword = $request->input('keyword');

        // レビュー検索の場合のみ処理（他のタイプも将来追加できるように）
        if ($type === 'review') {
            $placeIdsWithReviews = RestaurantReview::select('place_id')
                ->groupBy('place_id')
                ->pluck('place_id');

            $results = RestaurantReview::whereIn('place_id', $placeIdsWithReviews)
                ->where('restaurant_name', 'like', "%{$keyword}%")
                ->groupBy('place_id', 'restaurant_name')
                ->get(['place_id', 'restaurant_name']);

            return view('reviews.search_results', compact('results', 'keyword'));
        }

        // 他のタイプ or 未選択 → トップに戻すか、他ページへ
        return redirect()->back()->with('error', 'Please select a valid search type.');
    }


}
