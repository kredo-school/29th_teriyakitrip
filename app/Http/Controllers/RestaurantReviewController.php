<?php

namespace App\Http\Controllers;

use App\Models\Prefectures;
use Illuminate\Http\Request;
use App\Models\RestaurantReview;
use Illuminate\Support\Facades\Http;
use App\Models\RestaurantReviewPhoto;

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

    // 🔥 API のレスポンスを確認
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

        // 🔥 Google API から都道府県を取得
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
        $prefecture = Prefectures::where('name', $prefectureName)->first();
        $prefectureId = $prefecture ? $prefecture->id : null;


        $mainPhotoPath = null; // メイン画像のパス

        // 画像がアップロードされた場合
        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
    
            if (count($photos) > 0) {
                // 🔥 最初の画像をメイン画像として `restaurant_reviews` に保存
                $mainPhotoPath = $photos[0]->store('reviews', 'public');
            }
        }

        // `restaurant_reviews` テーブルにレビューを保存
        $review = RestaurantReview::create([
            'user_id' => auth()->id(), // 現在のユーザーID
            'place_id' => $request->place_id, // Google APIの place_id
            'prefecture_id' => $prefectureId, // 🔥 `prefecture_id` を保存
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

        $photos = [];
        if (isset($data['result']['photos'])) {
            foreach (array_slice($data['result']['photos'], 0, 3) as $photo) {
                $photos[] = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference={$photo['photo_reference']}&key={$apiKey}";
            }
        }

        // 必要な情報を取得
        $restaurant = [
            'place_id' => $place_id,
            'name' => $data['result']['name'] ?? 'Unknown Restaurant',
            'photos' => $photos, // ✅ 3枚の画像を渡す
            'photo' => $photo,
            'price_level' => $data['result']['price_level'] ?? null,
            'address' => $data['result']['formatted_address'] ?? 'No address available',
            'phone' => $data['result']['formatted_phone_number'] ?? 'N/A',
            'website' => $data['result']['website'] ?? '#',
            'lat' => $data['result']['geometry']['location']['lat'] ?? null,
            'lng' => $data['result']['geometry']['location']['lng'] ?? null,
            'opening_hours' => $data['result']['opening_hours']['weekday_text'] ?? [],
        ];

        // レビュー情報を取得
        $reviews = RestaurantReview::where('place_id', $place_id)->latest()->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        $reviewCount = $reviews->count();

        return view('reviews.show', compact('restaurant', 'reviews', 'averageRating', 'reviewCount'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantReview $restaurantReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RestaurantReview $restaurantReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantReview $restaurantReview)
    {
        //
    }
}
