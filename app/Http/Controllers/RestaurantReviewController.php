<?php

namespace App\Http\Controllers;

use App\Models\RestaurantReview;
use Illuminate\Http\Request;

class RestaurantReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Temporary dummy data
        $restaurant = (object) [
            'name' => 'ABC Cafe',
            'photo' => '/images/restaurants/default-restaurant.jpg',
        ];

        // If the logged-in user has included this restaurant in their itinerary.
        $userItineraries = collect([
            (object) [
                'title' => '2025 Kyoto Trip',
                'photo' => '/images/itineraries/kyoto.jpg',
            ],
            (object) [
                'title' => 'Japan Food Tour',
                'photo' => '/images/itineraries/kyoto2.jpg',
            ],
            (object) [
                'title' => 'Japan Food amazing perfect special Tour',
                'photo' => '/images/itineraries/kyoto2.jpg',
            ]
        ]);

        return view('reviews.create')
            ->with('restaurant', $restaurant)
            ->with('userItineraries', $userItineraries);
    }



    // I will code later when I need to make Backend part

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //     // validation
    //     $request->validate([
    //         'rating' => 'required|integer|min:1|max:5',
    //         'place_id' => 'nullable|string', // 後でGoogle APIから取得
    //         'title' => 'nullable|string|max:50',
    //         'body' => 'required|string',
    //         'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024', // 画像のみ, 最大1MB
    //     ]);
    
    //     // 仮の `place_id`（後で Google API に置き換える）
    //     $place_id = $request->place_id ?? 'dummy_place_id_123';
    
    //     // ✅ 1. レビューを作成し、DBに保存
    //     $review = RestaurantReview::create([
    //         'user_id' => auth()->id(), 
    //         'place_id' => $place_id,
    //         'rating' => $request->rating,
    //         'title' => $request->title,
    //         'body' => $request->body,
    //         'photo' => null, // メイン写真は最初は `null`
    //     ]);
    
    //     // ✅ 2. 画像を保存し、DB に登録
    //     if ($request->hasFile('photos')) {
    //         $photos = $request->file('photos');
    //         foreach ($photos as $index => $photo) {
    //             $path = $photo->store('review_photos', 'public'); // `storage/app/public/review_photos` に保存
    
    //             // 最初の画像をメイン画像にする
    //             if ($index === 0) {
    //                 $review->update(['photo' => $path]); // `restaurant_reviews` の `photo` に保存
    //             }
    
    //             // `restaurant_review_photos` に画像情報を保存
    //             RestaurantReviewPhoto::create([
    //                 'restaurant_review_id' => $review->id,
    //                 'photo' => $path,
    //             ]);
    //         }
    //     }
    
    //     return response()->json(['success' => true, 'message' => 'Review submitted successfully!']);
    }    

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // dummy data
        $restaurant = (object)[
            'name' => 'Sample Restaurant',
            'reviews' => [
                (object)[
                    'user' => (object)['name' => 'David.T', 'photo' => '/images/profiles/girl1.png'],
                    'rating' => 4,
                    'title' => 'What a surprise!',
                    'body' => 'I had a great experience! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Harum velit fugit tenetur quo dolorem delectus assumenda sit quaerat expedita laborum odit vitae, commodi iusto quam enim tempore maiores corporis ea.',
                    'photos' => [
                        (object)['photo' => '/images/misonikomiudon.jpg'],
                        (object)['photo' => '/images/kishimen.jpg'],
                        (object)['photo' => '/images/wagashi2.jpg'],
                    ],
                    'itinerary' => (object)[
                        'title' => '2025 Kyoto Trip',
                        'photo' => '/images/itineraries/kyoto.jpg',
                    ],
                ],
                (object)[
                    'user' => (object)['name' => 'Emily.C','photo' => null],
                    'rating' => 2,
                    'title' => 'No Title',
                    'body' => 'It took 20min to make coffee.',
                    'photos' => [
                        (object)['photo' => '/images/wagashi2.jpg'],
                    ],
                ],

                (object)[
                    'user' => (object)['name' => 'David.T', 'photo' => '/images/profiles/girl1.png'],
                    'rating' => 4,
                    'title' => 'What a surprise!',
                    'body' => 'I had a great experience! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Harum velit fugit tenetur quo dolorem delectus assumenda sit quaerat expedita laborum odit vitae, commodi iusto quam enim tempore maiores corporis ea.Lorem ipsum dolor sit, amet consectetur adipisicing elit. Harum velit fugit tenetur quo dolorem delectus assumenda sit quaerat expedita laborum odit vitae, commodi iusto quam enim tempore maiores corporis ea.',
                    'photos' => [
                        (object)['photo' => '/images/misonikomiudon.jpg'],
                        (object)['photo' => '/images/kishimen.jpg'],
                        (object)['photo' => '/images/wagashi2.jpg'],
                    ],
                    // David itinerary
                    'itinerary' => (object)[
                    'title' => '2025 Kyoto Trip',
                    'photo' => '/images/itineraries/kyoto.jpg',
                ],
                    
                ],
                (object)[
                    'user' => (object)['name' => 'Emily.C','photo' => null],
                    'rating' => 2,
                    'title' => 'No Title',
                    'body' => 'It took 20min to make coffee.',
                    'photos' => [
                        (object)['photo' => '/images/wagashi2.jpg'],
                    ],
                    // Emily itinerary
                    // 'itinerary' => (object)[
                    // 'title' => 'Kyoto Exploration',
                    // 'photo' => '/images/itineraries/kyoto2.jpg',
                    // ],
                ],
                (object)[
                    'user' => (object)['name' => 'David.T', 'photo' => '/images/profiles/girl1.png'],
                    'rating' => 4,
                    'title' => 'What a surprise!',
                    'body' => 'I had a great experience!',
                    'photos' => [
                        (object)['photo' => '/images/misonikomiudon.jpg'],
                        (object)['photo' => '/images/kishimen.jpg'],
                        (object)['photo' => '/images/wagashi2.jpg'],
                    ],
                    // David itinerary
                    'itinerary' => (object)[
                    'title' => '2025 Kyoto Trip',
                    'photo' => '/images/itineraries/kyoto.jpg',
                ],
                    
                ],
                
                (object)[
                    'user' => (object)['name' => 'David.T', 'photo' => '/images/profiles/girl1.png'],
                    'rating' => 4,
                    'title' => 'What a surprise!',
                    'body' => 'I had a great experience!',
                    'photos' => [
                        (object)['photo' => '/images/misonikomiudon.jpg'],
                        (object)['photo' => '/images/kishimen.jpg'],
                        (object)['photo' => '/images/wagashi2.jpg'],
                    ],
                    // David itinerary
                    'itinerary' => (object)[
                    'title' => '2025 Kyoto Trip',
                    'photo' => '/images/itineraries/kyoto.jpg',
                ],
                    
                ],
            ],
        ];

        // `reviews.show` ビューに `restaurant` データを渡して表示
        return view('reviews.show')->with('restaurant', $restaurant);
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
