<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\FollowController; //一時的にコメントアウト（後で戻す）
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\RegionController;//moko
use App\Http\Controllers\ApiProxyController; //naho
use App\Http\Controllers\MyItineraryController;//Toshimi
use App\Http\Controllers\RestaurantReviewController; //naho
use App\Http\Controllers\RestaurantSearchController; //naho
use App\Http\Controllers\FavoritesController; //Toshimi


Auth::routes();
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/restaurants/search', [RestaurantSearchController::class, 'index'])->name('restaurants.search'); //naho



Route::get('/itinerary/show', [ItineraryController::class, 'showItinerary'])->name('itineraries.show_itinerary');

Route::get('/my-itineraries', [MyItineraryController::class, 'index'])->name('my-itineraries.list'); //Toshimi
Route::get('/my-reviews', [ReviewController::class, 'myList'])->name('my-reviews.list');//Toshimi
Route::post('/review/delete', [ReviewController::class, 'destroy'])->name('review.delete');//Toshimi
Route::post('/itinerary/favorite/{id}', function ($id) {
    // ダミー処理: お気に入りの状態をトグルする（本来はデータベースを更新）Toshimi
    session()->put("favorite_$id", !session("favorite_$id", false));
    return redirect()->back(); // ページを更新して状態を反映
})->name('itinerary.favorite');


Route::group(['middleware' => 'auth'], function() { //Toshimi
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //Toshimi

    Route::get('/my-favorites', [FavoritesController::class, 'index']) //Toshimi
    // ->middleware('auth')  // ログインユーザーのみアクセス可能
    ->name('favorites.list');

});

// Route::get('/create-itinerary', [ItineraryController::class, 'create'])->name('create_itinerary');
Route::get('/create-review', [ReviewController::class, 'create'])->name('create_review');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');


//ログイン後のみ入れる
Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/restaurant-reviews/create', [RestaurantReviewController::class, 'create'])->name('restaurant-reviews.create'); //naho
    Route::post('/restaurant-reviews', [RestaurantReviewController::class, 'store'])->name('restaurant-reviews.store'); //naho
    Route::get('/restaurant-reviews/view', [RestaurantReviewController::class, 'show'])->name('reviews.show'); // naho

    // Route::get('/logout', 'Auth\LoginController@logout')->name('logout'); // エラー原因となったため一旦コメントアウト　支障あれば相談//Sunao
});
Route::group(['middleware' => 'auth'], function() {    
    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function () {
        Route::get('/create', [ItineraryController::class, 'create'])->name('create');// Sunao
        // Route::get('/itinerary_first_form', [ItineraryController::class, 'create'])->name('itineraries.create'); // フォーム表示
        Route::post('/store', [ItineraryController::class, 'store'])->name('store');// Sunao
        Route::post('/{id}/update-dates', [ItineraryController::class, 'updateDates']) ->name('update-dates'); // Sunao
        Route::get('/{id}/addList/create_itinerary', [ItineraryController::class, 'addList'])->name('addList'); // Sunao
        Route::post('/save/{id}', [ItineraryController::class, 'saveItineraryData'])
    ->name('save'); //Sunao
        // Route::get('/create_itinerary', [ItineraryController::class, 'addList'])->name('create_itinerary_header');
        // Route::post('/itinerary_first_form', [ItineraryController::class, 'showFirstform'])->name('showFirstform'); // フォーム送信処理
        // Edit itinerary P33
        Route::get('/edit', [ItineraryController::class, 'edit'])->name('edit_itinerary'); // SAKI
        Route::get('/{id}/edit-destination', [ItineraryController::class, 'editDestination'])->name('editDestination');
        Route::put('/{id}/update/', [ItineraryController::class, 'updateDestination'])->name('itinerary.updateDestination');
    });


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/api/photo', [ApiProxyController::class, 'fetchPhoto']); //naho
Route::get('/api/places', [ApiProxyController::class, 'fetchPlaces']); //naho

Route::get('/profile', function () {
    return view('profile', ['user' => Auth::user()]);
})->name('profile.show')->middleware('auth');


    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function() {
        Route::get('/create_add', [ItineraryController::class, 'show'])->name('show');
        // Route::get('/create', [ItineraryController::class, 'create'])->name('create');
    });
        Route::get('/{id}/edit-destination', [ItineraryController::class, 'editDestination'])->name('editDestination');
        Route::put('/{id}/update/', [ItineraryController::class, 'updateDestination'])->name('itinerary.updateDestination');

        // Route::post('/store', [ItineraryController::class, 'store'])->name('store');
        // Route::delete('/{user_id}/destroy', [ItineraryController::class, 'destroy'])->name('destroy');
        // Route::get('/{user_id}/edit', [ItineraryController::class, 'edit'])->name('edit');

Route::get('/reviews/show', [RestaurantReviewController::class, 'show'])->name('reviews.show');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/itineraries/create', [ItineraryController::class, 'addList'])->name('itinerary.create_itinerary_header'); //エラー原因となったため一旦コメントアウト　支障あれば相談//Sunao
    
// });
Route::get('/tabs', function () {
    return view('tabs');
});

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

//  region:Overview moko
Route::get('/regions/overview', [RegionController::class, 'overview']);

//  region:Itinerary moko
Route::get('/regions/itinerary', [RegionController::class, 'itinerary']);

// region: Restaurant Review moko
Route::get('/regions/restaurant-review', [RegionController::class, 'restaurantReview']);

// Route::get('/', [ItineraryController::class, 'index'])->name('mypage.itinerary.show');
Route::post('/itineraries', [ItineraryController::class, 'store'])->name('store_itinerary');

//プロフィール閲覧で使用するユーザー情報の取得
Route::get('/profile/{id}',[ProfileController::class,'get_user']);

//フォロー状態の確認 // 一時的にコメントアウト（後で戻す）
// Route::get('/follow/status/{id}',[FollowController::class,'check_following']);

//フォロー付与 // 一時的にコメントアウト（後で戻す）
// Route::post('/follow/add',[FollowController::class,'following']);

//フォロー解除 // 一時的にコメントアウト（後で戻す）
// Route::post('/follow/remove',[FollowController::class,'unfollowing']);

Route::group(['middleware' => 'auth'], function() {
    // Route::get('/show','FollowsController@show');
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
    
// Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itineraries.index'); //NozomiさんがFix中
Route::get('/restaurant-reviews', [RestaurantReviewController::class, 'index'])->name('restaurant_reviews.index');

// マイページ関連のルートを単一のルートにまとめる
Route::get('/mypage/{tab?}', [MypageController::class, 'show'])
    ->name('mypage.show')
    ->where('tab', 'overview|itineraries|restaurant_reviews');

// デフォルトのホームページをMypageControllerのindexアクションに設定
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
});
