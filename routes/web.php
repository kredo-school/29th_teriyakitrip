<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\RestaurantReviewController; //naho
use App\Http\Controllers\RestaurantSearchController; //naho
use App\Http\Controllers\ApiProxyController; //naho

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/reviews/show', [RestaurantReviewController::class, 'show'])->name('reviews.show'); //naho
Route::get('/restaurants/search', [RestaurantSearchController::class, 'index'])->name('restaurants.search'); //naho

Route::get('/itinerary/show', [ItinerariesController::class, 'showItinerary'])->name('itineraries.show_itinerary');

//ログイン後のみ入れる
Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/restaurant-reviews/create', [RestaurantReviewController::class, 'create'])->name('restaurant-reviews.create'); //naho
    Route::post('/restaurant-reviews', [RestaurantReviewController::class, 'store'])->name('restaurant-reviews.store'); //naho

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

        
    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function() {
        Route::get('/create_add', [ItinerariesController::class, 'show'])->name('show');
        Route::get('/create', [ItinerariesController::class, 'create'])->name('create');
        // 画面を表示するための GET ルート
        Route::get('/itinerary_first_form', [ItinerariesController::class, 'create'])->name('itineraries.create'); // フォーム表示
        Route::post('/itinerary_first_form', [ItinerariesController::class, 'showFirstform'])->name('showFirstform'); // フォーム送信処理

        Route::get('/create_itinerary/{id}', [ItinerariesController::class, 'addList'])->name('itineraries.create_itinerary'); // しおり表示
        // Edit itinerary P33
        Route::get('/edit', [ItinerariesController::class, 'edit'])->name('edit_itinerary'); // SAKI
        Route::get('/{id}/edit-destination', [ItinerariesController::class, 'editDestination'])->name('editDestination');
        Route::put('/{id}/update/', [ItinerariesController::class, 'updateDestination'])->name('itinerary.updateDestination');
    });
});



Route::get('/api/photo', [ApiProxyController::class, 'fetchPhoto']); //naho

Route::get('/api/places', [ApiProxyController::class, 'fetchPlaces']); //naho
