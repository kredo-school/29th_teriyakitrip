<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\RegionsController;//moko
use App\Http\Controllers\ApiProxyController; //naho
use App\Http\Controllers\ItineraryController;//Toshimi
use App\Http\Controllers\RestaurantReviewController; //naho
use App\Http\Controllers\RestaurantSearchController; //naho

Auth::routes();
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/show', [ItinerariesController::class, 'showItinerary'])->name('itineraries.show_itinerary');

Route::get('/my-itineraries', [ItineraryController::class, 'index'])->name('my-itineraries.list'); //Toshimi
Route::get('/my-reviews', [ReviewController::class, 'myList'])->name('my-reviews.list');//Toshimi
Route::post('/review/delete', [ReviewController::class, 'destroy'])->name('review.delete');//Toshimi
Route::post('/itinerary/favorite/{id}', function ($id) {
    // ダミー処理: お気に入りの状態をトグルする（本来はデータベースを更新）Toshimi
    session()->put("favorite_$id", !session("favorite_$id", false));
    return redirect()->back(); // ページを更新して状態を反映
})->name('itinerary.favorite');

// Route::get('/create-itinerary', [ItineraryController::class, 'create'])->name('create_itinerary');
Route::get('/create-review', [ReviewController::class, 'create'])->name('create_review');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::get('/restaurant-reviews/view', [RestaurantReviewController::class, 'show'])->name('reviews.show'); // naho

//ログイン後のみ入れる
Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/restaurants/search', [RestaurantSearchController::class, 'index'])->name('restaurants.search'); //naho
    Route::get('/restaurant-reviews/create', [RestaurantReviewController::class, 'create'])->name('restaurant-reviews.create'); //naho
    Route::post('/restaurant-reviews', [RestaurantReviewController::class, 'store'])->name('restaurant-reviews.store'); //naho

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function () {

    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function () {
        Route::get('/create_add', [ItinerariesController::class, 'show'])->name('show');
        Route::get('/create', [ItinerariesController::class, 'create'])->name('create');
        Route::get('/create_itinerary', [ItinerariesController::class, 'addList'])->name('create_itinerary_header');
        // Edit itinerary P33
        Route::get('/edit', [ItinerariesController::class, 'edit'])->name('edit_itinerary'); // SAKI
        Route::get('/{id}/edit-destination', [ItinerariesController::class, 'editDestination'])->name('editDestination');
        Route::put('/{id}/update/', [ItinerariesController::class, 'updateDestination'])->name('itinerary.updateDestination');
    });
});

Route::get('/api/photo', [ApiProxyController::class, 'fetchPhoto']); //naho
Route::get('/api/places', [ApiProxyController::class, 'fetchPlaces']); //naho

Route::get('/profile', function () {
    return view('profile', ['user' => Auth::user()]);
})->name('profile.show')->middleware('auth');


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




// Route::get('/regions/restaurant-review', function () {
//     return view('Regions.restaurant_review', [
//         'allRestaurants' => [
//             ['img' => 'what-is-unagi-gettyimages-13043474274x3-7c4d7358c68d48d7ad029159563608d0.jpg', 'title' => 'ICHIBAN Unagi', 'description' => 'Delicious grilled eel with sweet sauce.', 'rating' => 4],
//             ['img' => 'download (1).jpg', 'title' => 'ABC Italian', 'description' => 'Authentic Italian pasta with a Japanese twist.', 'rating' => 3],
//             ['img' => 'ダウンロード.jpg', 'title' => 'Sapporo Ramen', 'description' => 'Rich miso ramen, a specialty of Sapporo.', 'rating' => 5],
//             ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Sushi', 'description' => 'Fresh seafood sushi from the best fish markets.', 'rating' => 2],
//             ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Seafood Grill', 'description' => 'Grilled seafood platter with local flavors.', 'rating' => 5]
//         ]
//     ]);
// });
    
Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itineraries.index');
Route::get('/restaurant-reviews', [RestaurantReviewController::class, 'index'])->name('restaurant_reviews.index');

// マイページ関連のルートを単一のルートにまとめる
Route::get('/mypage/{tab?}', [MypageController::class, 'show'])
    ->name('mypage.show')
    ->where('tab', 'overview|itineraries|restaurant_reviews');

// デフォルトのホームページをMypageControllerのindexアクションに設定
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');





Route::get('/regions/{prefecture_id}/overview', [RegionsController::class, 'overview'])
    ->name('regions.overview'); //naho

Route::get('/regions/{prefecture_id}/restaurant-review', [RegionsController::class, 'restaurantReview'])
    ->name('regions.restaurant-review'); //naho

Route::get('/regions/{prefecture_id}/itinerary', [RegionsController::class, 'itinerary'])
    ->name('regions.itinerary'); //naho