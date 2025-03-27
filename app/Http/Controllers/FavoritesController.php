<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteItinerary;
use App\Models\FavoriteRestaurant;
use App\Models\Itinerary;
use App\Models\RestaurantReview;

class FavoritesController extends Controller
{
    // Itinerary お気に入りのトグル
    public function toggleFavoriteItinerary(Request $request, $itineraryId)
    {
        $user = Auth::user();

        $favorite = FavoriteItinerary::where('user_id', $user->id)
            ->where('itinerary_id', $itineraryId)
            ->first();

        if ($favorite) {
            $favorite->delete(); // 既存のお気に入りを削除
        } else {
            FavoriteItinerary::create([
                'user_id' => $user->id,
                'itinerary_id' => $itineraryId,
            ]); // 新しくお気に入りを追加
        }

        return redirect()->back(); // ← これ重要！リダイレクトでページを保つ
    }

    // Restaurant お気に入りのトグル
    public function toggleFavoriteRestaurant(Request $request, $placeId)
    {
        $user = Auth::user();
        $favorite = FavoriteRestaurant::where('user_id', $user->id)
            ->where('place_id', $placeId)
            ->first();

        if ($favorite) {
            $favorite->delete(); // 既存のお気に入りを削除
        } else {
            FavoriteRestaurant::create([
                'user_id' => $user->id,
                'place_id' => $placeId
            ]); // 新しくお気に入りを追加
        }

        return redirect()->back(); // ← これ重要！リダイレクトでページを保つ
    }

    // ユーザーのお気に入り一覧を表示
    public function indexWithItinerary($prefectureId) // 名前を変更して新しいメソッドを作成
    {
        $favoriteItineraries = FavoriteItinerary::where('user_id', Auth::id())
            ->with('itinerary')
            ->get();

        return view('favorites.my_favorite', compact('favoriteItineraries'));
    }

    public function indexWithRestaurant($prefectureId) // 名前を変更して新しいメソッドを作成
    {
        $favoriteRestaurants = FavoriteRestaurant::where('user_id', Auth::id())
            ->with(['review' => function ($query) {
                $query->latest(); // 必要なら
            }])
            ->get();

        return view('favorites.my_favorite', compact('favoriteRestaurants'));
    }

    // すべてのデータを表示したい場合
    public function index()
    {
        $favoriteItineraries = FavoriteItinerary::where('user_id', Auth::id())
            ->with('itinerary')
            ->get();

        $favoriteRestaurants = FavoriteRestaurant::where('user_id', Auth::id())
            ->with(['review' => function ($query) {
                $query->latest(); // 必要なら
            }])
            ->get();

        return view('favorites.my_favorite', compact('favoriteItineraries', 'favoriteRestaurants'));
    }


}
