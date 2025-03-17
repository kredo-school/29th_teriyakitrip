<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TabController;
// use App\Http\Controllers\FollowController; //一時的にコメントアウト（後で戻す）
use App\Http\Controllers\UserController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegionController;//moko
use App\Http\Controllers\ApiProxyController; //naho
use App\Http\Controllers\FavoritesController; //Toshimi
use App\Http\Controllers\MyItineraryController;//Toshimi
use App\Http\Controllers\RestaurantReviewController; //naho
use App\Http\Controllers\RestaurantSearchController; //naho


Auth::routes();


Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


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
    Route::get('/my-favorites', [FavoritesController::class, 'index']) //Toshimi
    // ->middleware('auth')  // ログインユーザーのみアクセス可能
    ->name('favorites.list');

});

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
    Route::get('/restaurant-reviews/view', [RestaurantReviewController::class, 'show'])->name('reviews.show'); // naho
    // Route::get('/logout', 'Auth\LoginController@logout')->name('logout'); // エラー原因となったため一旦コメントアウト 支障あれば相談//Sunao
    Route::get('/restaurants/my_review/{id}', [RestaurantReviewController::class, 'viewMyreview'])->name('reviews.view_myreview'); //saki
    
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});
Route::group(['middleware' => 'auth'], function() {    
    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function () {
        Route::get('/create_add', [ItineraryController::class, 'show'])->name('show');
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
});


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

// Route::middleware(['auth'])->group(function () {
//     Route::get('/itineraries/create', [ItineraryController::class, 'addList'])->name('itinerary.create_itinerary_header'); //エラー原因となったため一旦コメントアウト　支障あれば相談//Sunao
    
// });
Route::get('/tabs', function () {
    return view('tabs');
});

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Route::get('/', [ItinerariesController::class, 'index'])->name('mypage.itinerary.show');
Route::post('/itineraries', [ItinerariesController::class, 'store'])->name('store_itinerary');

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


    

Route::get('/restaurant-reviews', [RestaurantReviewController::class, 'index'])->name('restaurant_reviews.index');

//以下のルートはbladeのファイルごと読み込むが、タブで切り替えるようにしたので以下のルートは必要なしの予定　naho
// マイページ関連のルートを単一のルートにまとめる
// Route::get('/mypage/{tab?}', [MypageController::class, 'show'])
//     ->name('mypage.show')
//     ->where('tab', 'overview|itineraries|restaurant_reviews|followings|follower');

// デフォルトのホームページをMypageControllerのindexアクションに設定
Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');

Route::get('/mypage/get-restaurant-name', [MypageController::class, 'getRestaurantName']);


Route::get('/regions/{prefecture_id}/overview', [RegionController::class, 'overview'])
    ->name('regions.overview'); //naho

Route::get('/regions/{prefecture_id}/restaurant-review', [RegionController::class, 'restaurantReview'])
    ->name('regions.restaurant-review'); //naho

Route::get('/regions/{prefecture_id}/itinerary', [RegionController::class, 'itinerary'])
    ->name('regions.itinerary'); //naho
