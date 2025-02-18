<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/reviews/test', function () {
//     // fake data for checking the reviews list view
//     $reviews = [
//         (object)[
//             'user' => (object)['name' => 'David.T'],
//             'rating' => 4,
//             'title' => 'What a surprise!',
//             'body' => 'I had a great experience!',
//             'photos' => [
//                 (object)['photo' => '/images/misonikomiudon.jpg'],
//                 (object)['photo' => '/images/kishimen.jpg'],
//             ],
//         ],
//         (object)[
//             'user' => (object)['name' => 'Emily.C'],
//             'rating' => 2,
//             'title' => 'No Title',
//             'body' => 'It took 20min to make coffee.',
//             'photos' => [
//                 (object)['photo' => '/images/wagashi2.jpg'],
//             ],
//         ],
//     ];

//     return view('reviews.list', compact('reviews'));
// });

Route::get('/reviews/show', function () {
    // fake data
    $restaurant = (object)[
        'name' => 'Sample Restaurant',
        'reviews' => [
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
        ],
    ];

    // show.blade.php を表示
    return view('reviews.show')->with('restaurant', $restaurant);
});


