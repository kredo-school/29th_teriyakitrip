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
use App\Http\Controllers\GooglePlaceController;
use App\Http\Controllers\ItinerarySpotController;


Auth::routes();
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/restaurants/search', [RestaurantSearchController::class, 'index'])->name('restaurants.search'); //naho
Route::get('/restaurant-reviews/view', [RestaurantReviewController::class, 'show'])->name('reviews.show'); // naho
Route::get('/my-itineraries', [MyItineraryController::class, 'index'])->name('my-itineraries.list'); //Toshimi
Route::put('/my-itineraries/{id}/privacy', [MyItineraryController::class, 'updatePrivacy'])->name('my-itineraries.updatePrivacy');
// ルートの修正: DELETEメソッドを使用
Route::delete('/my-itineraries/{id}', [MyItineraryController::class, 'destroy'])->name('myitinerary.destroy');



Route::get('/itinerary/show', [ItineraryController::class, 'showItinerary'])->name('itineraries.show_itinerary');
Route::get('/my-reviews', [ReviewController::class, 'myList'])->name('my-reviews.list');//Toshimi
Route::post('/review/delete', [ReviewController::class, 'destroy'])->name('review.delete');//Toshimi
Route::post('/itinerary/favorite/{id}', function ($id) {
    // ダミー処理: お気に入りの状態をトグルする（本来はデータベースを更新）Toshimi
    session()->put("favorite_$id", !session("favorite_$id", false));
    return redirect()->back(); // ページを更新して状態を反映
})->name('itinerary.favorite');


Route::group(['middleware' => 'auth'], function() { //Toshimi
   
    Route::get('/my-favorites', [FavoritesController::class, 'index']) //Toshimi
    // ->middleware('auth')  // ログインユーザーのみアクセス可能
    ->name('favorites.list');

});

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
    Route::get('/restaurants/my_review/{id}', [RestaurantReviewController::class, 'viewMyreview'])->name('reviews.view_myreview'); //saki
    // Edit review form
    Route::get('/reviews/edit/{review}', [RestaurantReviewController::class, 'edit'])->name('reviews.edit_myreview'); //SAKI
    Route::put('/reviews/{id}', [RestaurantReviewController::class, 'update'])->name('reviews.update'); //SAKI
    // 画像削除のルート設定
    Route::delete('/reviews/photo/delete/{photoId}', [RestaurantReviewController::class, 'deletePhoto'])->name('review.photo.delete');
});

Route::group(['middleware' => 'auth'], function() {    
    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function () {
        Route::get('/create', [ItineraryController::class, 'create'])->name('create');// Sunao
        Route::post('/store', [ItineraryController::class, 'store'])->name('store');// Sunao
        Route::post('/{id}/update-dates', [ItineraryController::class, 'updateDates']) ->name('update-dates'); // Sunao
        Route::get('/{id}/addList/create_itinerary', [ItineraryController::class, 'addList'])->name('addList');
        // Sunao
        Route::post('/save/{id}', [ItineraryController::class, 'saveItineraryData']) ->name('save');//sunao     

        // Route::get('/edit', [ItineraryController::class, 'edit'])->name('edit_itinerary'); // SAKI
        // Route::get('/{id}/edit-destination', [ItineraryController::class, 'editDestination'])->name('editDestination');
        // Route::put('/{id}/update/', [ItineraryController::class, 'updateDestination'])->name('itinerary.updateDestination');
    });

//Itinerary の spot 検索
Route::get('/search-spot', [GooglePlaceController::class, 'searchSpotDetail'])->name('search.spot');
Route::get('/search-photo/{place_id}', [GooglePlaceController::class, 'searchPhoto'])->name('search.photo');
Route::get('/api/get-place-info/{place_id}', [GooglePlaceController::class, 'getPlaceInfo']);
Route::get('/spots/photo/{place_id}', [GooglePlaceController::class, 'getPhoto'])->name('spots.photo');

//Spot 情報をitinerarySpotsテーブルへ保存
Route::get('/itineraries/{id}/day/{visit_day}/search', [ItinerarySpotController::class, 'showSearchSpot'])
    ->name('itineraries.spot.search')
    ->whereNumber('visit_day'); // ✅ `day` は数値のみ許可！
Route::post('/itineraries/{id}/day/{visit_day}/save/spots', [ItinerarySpotController::class, 'saveItinerarySpots'])->name('itineraries.spots.save');
Route::get('/itinerary/{id}/show-spots', [ItinerarySpotController::class, 'showSpots'])->name('itineraries.showSpots');
Route::get('/api/itinerary/{id}/spots', [ItinerarySpotController::class, 'getSpotsByItinerary']);//Sunao   

Route::delete('/itineraries/spots/{spotId}/delete', [ItinerarySpotController::class, 'deleteSpot']);
Route::delete('/itineraries/{id}/day/{visit_day}/delete-spots-by-day', [ItinerarySpotController::class, 'deleteSpotsByDay'])
    ->name('itinerary.spots.delete_by_day');




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/api/photo', [ApiProxyController::class, 'fetchPhoto']); //naho
Route::get('/api/places', [ApiProxyController::class, 'fetchPlaces']); //naho

Route::get('/profile', function () {
    return view('profile', ['user' => Auth::user()]);
})->name('profile.show')->middleware('auth');

Route::get('/reviews/show', [RestaurantReviewController::class, 'show'])->name('reviews.show');

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

//プロフィール閲覧で使用するユーザー情報の取得
Route::get('/profile/{id}',[ProfileController::class,'get_user']);

//フォロー状態の確認 // 一時的にコメントアウト（後で戻す）
// Route::get('/follow/status/{id}',[FollowController::class,'check_following']);

//フォロー付与 // 一時的にコメントアウト（後で戻す）
// Route::post('/follow/add',[FollowController::class,'following']);

//フォロー解除 // 一時的にコメントアウト（後で戻す）
// Route::post('/follow/remove',[FollowController::class,'unfollowing']);
});

Route::group(['middleware' => 'auth'], function() {
    // Route::get('/show','FollowsController@show');
    });
Route::get('/restaurant-reviews/create', [RestaurantReviewController::class, 'create'])->name('restaurant-reviews.create');
Route::post('/restaurant-reviews', [RestaurantReviewController::class, 'store'])->name('restaurant-reviews.store');

// Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itineraries.index'); //NozomiさんがFix中
Route::get('/restaurant-reviews', [RestaurantReviewController::class, 'index'])->name('restaurant_reviews.index');

// マイページ関連のルートを単一のルートにまとめる
Route::get('/mypage/{tab?}', [MypageController::class, 'show'])
    ->name('mypage.show')
    ->where('tab', 'overview|itineraries|restaurant_reviews');

// デフォルトのホームページをMypageControllerのindexアクションに設定
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');

Route::get('/other_users_page/{userId}', [MypageController::class, 'showOtheruserspage'])->name('mypage.show_others');

Route::get('/mypage/get-restaurant-name', [MypageController::class, 'getRestaurantName']);


Route::get('/regions/{prefecture_id}/overview', [RegionController::class, 'overview'])
    ->name('regions.overview'); //naho

Route::get('/regions/{prefecture_id}/restaurant-review', [RegionController::class, 'restaurantReview'])
    ->name('regions.restaurant-review'); //naho

Route::get('/regions/{prefecture_id}/itinerary', [RegionController::class, 'itinerary'])
    ->name('regions.itinerary'); //naho

// Toshimi - Favorite function
Route::middleware(['auth'])->group(function () {
    Route::post('/favorites/toggle/{placeId}', [FavoritesController::class, 'toggleFavoriteRestaurant'])
        ->name('favorites.toggle.restaurant');

    Route::post('/itinerary/favorite/{id}', [FavoritesController::class, 'toggleFavoriteItinerary'])
        ->name('itinerary.favorite');
});