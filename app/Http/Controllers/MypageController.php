<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Itinerary;
use App\Models\RestaurantReview;
use App\Models\User;

class MypageController extends Controller
{
    public function show($tab = 'overview')
{
    $user = Auth::user();
    $itineraries = Itinerary::where('user_id', $user->id)->get();
    $restaurantReviews = RestaurantReview::where('user_id', $user->id)->get();
    // $followers = $user->followers()->paginate(20);
    // $following = $user->following()->paginate(20);

    // タブに応じて適切なビューを返す
    switch($tab) {
        case 'itineraries':
            return view('mypage.itineraries', compact('user', 'itineraries', 'tab'));
        case 'restaurant_reviews':
            return view('mypage.restaurant_reviews', compact('user', 'restaurantReviews', 'tab'));
        // case 'followers':
        //     // followers機能が実装されていない場合は、一時的にoverviewにリダイレクト
        //     return redirect()->route('mypage.show', 'followers');
        // case 'following':
        //     // following機能が実装されていない場合は、一時的にoverviewにリダイレクト
        //     return redirect()->route('mypage.show', 'following');
        default:
            return view('mypage.overview', compact('user', 'itineraries', 'restaurantReviews', 'tab'));
    
    }
}
}