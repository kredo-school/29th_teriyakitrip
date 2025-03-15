<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RestaurantReview; // Review モデルを使用
/**
 * ログインユーザーのレストランレビュー一覧を取得
 */

use Illuminate\Support\Facades\Http; // Google API 呼び出し用

class ReviewController extends Controller
{
    /**
     * レビュー作成画面を表示
     */
    public function create()
    {
        return view('create_review');
    }


    public function myList(Request $request)
    {
        // ログインユーザーが書いたレビューのみを取得
        $reviews = RestaurantReview::where('user_id', Auth::id())->get();

        $apiKey = env('GOOGLE_MAPS_API_KEY'); // Google APIキーを取得

        foreach ($reviews as $review) {
            // Google Places API を呼び出してレストラン情報を取得
            $apiUrl = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$review->place_id}&key={$apiKey}&language=en";
            $response = Http::get($apiUrl);
            $data = $response->json();

            // レストラン名を取得できたら `restaurant_name` を追加
            $review->restaurant_name = $data['result']['name'] ?? 'Unknown Restaurant';
        }

        return view('reviews.mylist', ['reviews' => $reviews]);
    }


    /**
     * レビュー削除処理
     */
    public function destroy(Request $request)
    {
        $reviewId = $request->input('review_id');

        // 該当のレビューを取得
        $review = RestaurantReview::findOrFail($reviewId);

        // レビューが現在のユーザーのものでなければ削除できないようにする
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('my-reviews.list')->with('error', 'You cannot delete this review.');
        }

        // 🛠 完全削除
        $review->forceDelete();

        return redirect()->route('my-reviews.list')->with('success', 'Review deleted successfully.');
    }
}
