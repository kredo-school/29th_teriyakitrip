<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\RestaurantReviewController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\MypageController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// Route::get('/create-itinerary', [ItineraryController::class, 'create'])->name('create_itinerary');
Route::get('/create-review', [ReviewController::class, 'create'])->name('create_review');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function() {
        Route::get('/create_add', [ItinerariesController::class, 'show'])->name('show');
        Route::get('/create', [ItinerariesController::class, 'create'])->name('create');
    });
        Route::get('/{id}/edit-destination', [ItinerariesController::class, 'editDestination'])->name('editDestination');
        Route::put('/{id}/update/', [ItinerariesController::class, 'updateDestination'])->name('itinerary.updateDestination');

        // Route::post('/store', [ItinerariesController::class, 'store'])->name('store');
        // Route::delete('/{user_id}/destroy', [ItinerariesController::class, 'destroy'])->name('destroy');
        // Route::get('/{user_id}/edit', [ItinerariesController::class, 'edit'])->name('edit');



Route::get('/reviews/show', [RestaurantReviewController::class, 'show'])->name('reviews.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/itineraries/create', [ItinerariesController::class, 'addList'])->name('itinerary.create_itinerary_header');
    
});


Route::get('/tabs', function () {
    return view('tabs');
});

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

Route::get('/create-itinerary', [App\Http\Controllers\ItinerariesController::class, 'create'])->name('create_itinerary');

Route::get('/create-review', [App\Http\Controllers\ReviewController::class, 'create'])->name('create_review');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Route::get('/', [ItinerariesController::class, 'index'])->name('mypage.itinerary.show');
Route::post('/itineraries', [ItinerariesController::class, 'store'])->name('store_itinerary');

//プロフィール閲覧で使用するユーザー情報の取得
Route::get('/profile/{id}',[ProfileController::class,'get_user']);

//フォロー状態の確認
Route::get('/follow/status/{id}',[FollowController::class,'check_following']);

//フォロー付与
Route::post('/follow/add',[FollowController::class,'following']);

//フォロー解除
Route::post('/follow/remove',[FollowController::class,'unfollowing']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/show','FollowsController@show');
    });
Route::get('/restaurant-reviews/create', [RestaurantReviewController::class, 'create'])->name('restaurant-reviews.create');
Route::post('/restaurant-reviews', [RestaurantReviewController::class, 'store'])->name('restaurant-reviews.store');

Route::get('/regions/overview', function () {
    return view('Regions.home', [
        'allItineraries' => [
            ['img' => 'biei_flower16.jpg', 'title' => '2025 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Experience the best of Hokkaido.'],
            ['img' => 'OIP.jpg', 'title' => '2023 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Explore the beauty of Japan’s north.'],
            ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2022 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Enjoy the scenic landscapes.'],
            ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2021 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Discover hidden gems in Hokkaido.'],
            ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2020 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Snowy wonderland adventures.']
        ],
        'allRestaurants' => [
            ['img' => 'what-is-unagi-gettyimages-13043474274x3-7c4d7358c68d48d7ad029159563608d0.jpg', 'title' => 'ICHIBAN Unagi', 'description' => 'Delicious grilled eel with sweet sauce.', 'rating' => 4],
            ['img' => 'download (1).jpg', 'title' => 'ABC Italian', 'description' => 'Authentic Italian pasta with a Japanese twist.', 'rating' => 3],
            ['img' => 'ダウンロード.jpg', 'title' => 'Sapporo Ramen', 'description' => 'Rich miso ramen, a specialty of Sapporo.', 'rating' => 5],
            ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Sushi', 'description' => 'Fresh seafood sushi from the best fish markets.', 'rating' => 2],
            ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Seafood Grill', 'description' => 'Grilled seafood with local ingredients.', 'rating' => 5]
        ]
    ]);
});


Route::get('/regions/itinerary', function () {
    return view('Regions.itinerary', [
        'allItineraries' => [
            ['img' => 'biei_flower16.jpg', 'title' => '2025 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Enjoy the scenic beauty of Hokkaido.'],
            ['img' => 'OIP.jpg', 'title' => '2023 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Discover the hidden gems of Japan’s northern island.'],
            ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2022 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Snowy landscapes and warm hot springs.'],
            ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2021 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...Experience the culture and cuisine of Hokkaido.'],
            ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2020 Hokkaido Trip', 'description' => '[Day 1] Shakadang Trail, Jiufen Township > Xiaoxihu Trail > Chongqing Shrine...A journey through Japan’s winter wonderland.']
        ]
    ]);
});


Route::get('/regions/restaurant-review', function () {
    return view('Regions.restaurant_review', [
        'allRestaurants' => [
            ['img' => 'what-is-unagi-gettyimages-13043474274x3-7c4d7358c68d48d7ad029159563608d0.jpg', 'title' => 'ICHIBAN Unagi', 'description' => 'Delicious grilled eel with sweet sauce.', 'rating' => 4],
            ['img' => 'download (1).jpg', 'title' => 'ABC Italian', 'description' => 'Authentic Italian pasta with a Japanese twist.', 'rating' => 3],
            ['img' => 'ダウンロード.jpg', 'title' => 'Sapporo Ramen', 'description' => 'Rich miso ramen, a specialty of Sapporo.', 'rating' => 5],
            ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Sushi', 'description' => 'Fresh seafood sushi from the best fish markets.', 'rating' => 2],
            ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Seafood Grill', 'description' => 'Grilled seafood platter with local flavors.', 'rating' => 5]
        ]
    ]);
});
    
Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itineraries.index');
Route::get('/restaurant-reviews', [RestaurantReviewController::class, 'index'])->name('restaurant_reviews.index');

// マイページ関連のルートを単一のルートにまとめる
Route::get('/mypage/{tab?}', [MypageController::class, 'show'])
    ->name('mypage.show')
    ->where('tab', 'overview|itineraries|restaurant_reviews');

// デフォルトのホームページをMypageControllerのindexアクションに設定
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
