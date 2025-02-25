<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\RestaurantReviewController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'itineraries', 'as' => 'itineraries.'], function() {
        Route::get('/create_add', [ItinerariesController::class, 'show'])->name('show');
        Route::get('/create', [ItinerariesController::class, 'create'])->name('create');
    });

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

Route::get('/', [ItinerariesController::class, 'index'])->name('mypage.itinerary.show');
Route::post('/itineraries', [ItinerariesController::class, 'store'])->name('store_itinerary');
