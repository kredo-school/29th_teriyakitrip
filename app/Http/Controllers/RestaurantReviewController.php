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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // ダミーデータ
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
