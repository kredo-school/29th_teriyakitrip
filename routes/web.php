<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegionsController;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'regions', 'as' => 'regions.'], function() {
    Route::get('/', [RegionsController::class, 'show'])->name('show');
   
});
