<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\RestaurantReviewController;
use App\Http\Controllers\RestaurantSearchController;
use App\Http\Controllers\ApiProxyController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ログイン後のみ入れる
Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

        Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function() {
            Route::get('/create_add', [ItinerariesController::class, 'show'])->name('show');
            Route::get('/create', [ItinerariesController::class, 'create'])->name('create');
            // Route::post('/store', [ItinerariesController::class, 'store'])->name('store');
            // Route::delete('/{user_id}/destroy', [ItinerariesController::class, 'destroy'])->name('destroy');
            // Route::get('/{user_id}/edit', [ItinerariesController::class, 'edit'])->name('edit');
        });
});

Route::get('/reviews/show', [RestaurantReviewController::class, 'show'])->name('reviews.show');

Route::get('/restaurants/search', [RestaurantSearchController::class, 'index'])->name('restaurants.search');

Route::get('/api/photo', [ApiProxyController::class, 'fetchPhoto']);

Route::get('/api/places', [ApiProxyController::class, 'fetchPlaces']);

//ログイン後のみ入れる
Route::middleware(['auth'])->group(function () {
    Route::get('/itineraries/create', [ItinerariesController::class, 'addList'])->name('itinerary.create_itinerary_header');
    
});


Route::get('/tabs', function () {
    return view('tabs');
});
