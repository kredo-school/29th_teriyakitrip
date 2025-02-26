<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\RestaurantReviewController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function() {
        Route::get('/create_add', [ItinerariesController::class, 'show'])->name('show');
        Route::get('/create', [ItinerariesController::class, 'create'])->name('create');
        Route::get('/create_itinerary', [ItinerariesController::class, 'addList'])->name('itineraries.create_itinerary_header');
        // Edit itinerary P33
        Route::get('/edit', [ItinerariesController::class, 'edit'])->name('itineraries.edit_itinerary');
        Route::get('/{id}/edit-destination', [ItinerariesController::class, 'editDestination'])->name('editDestination');
        Route::put('/{id}/update/', [ItinerariesController::class, 'updateDestination'])->name('itinerary.updateDestination');

        // Route::post('/store', [ItinerariesController::class, 'store'])->name('store');
        // Route::delete('/{user_id}/destroy', [ItinerariesController::class, 'destroy'])->name('destroy');
        // Route::get('/{user_id}/edit', [ItinerariesController::class, 'edit'])->name('edit');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/reviews/show', [RestaurantReviewController::class, 'show'])->name('reviews.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/itineraries/create', [ItinerariesController::class, 'addList'])->name('itinerary.create_itinerary_header');
    
});
Route::get('/tabs', function () {
    return view('tabs');
});
