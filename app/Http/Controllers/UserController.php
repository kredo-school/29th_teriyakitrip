<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Itineraries;
use App\Models\RestaurantReview;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 特定のユーザーのプロフィールを表示します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $itineraries = Itineraries::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $restaurantReviews = RestaurantReview::where('user_id', $user->id)
            ->orderBy('likes', 'desc')
            ->get();

        return view('profile.show', compact('user', 'itineraries', 'restaurantReviews'));
    }
}