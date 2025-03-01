<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    //
    public function create()
    {
        return view('create_review');
    }


    public function myList(Request $request) // Toshimi 作成
    {
        // 仮のダミーデータ（DB接続前の段階）
        $reviews = [
            ['restaurant' => 'Sushi Place', 'rating' => 5, 'image' => 'images/review1.jpg', 'review' => 'Best sushi in town!', 'user' => 'User123', 'user_id' => 1],
            ['restaurant' => 'Ramen House', 'rating' => 4, 'image' => 'images/review2.jpg', 'review' => 'Great ramen, but a bit expensive.', 'user' => 'User456', 'user_id' => 2],
            ['restaurant' => 'Cafe Delight', 'rating' => 3, 'image' => 'images/review3.jpg', 'review' => 'Good coffee but slow service.', 'user' => 'User123', 'user_id' => 1],
        ];

        // ログインユーザーのみのレビューをフィルタリング
        $userId = Auth::id(); // 現在のログインユーザーのIDを取得
        $reviews = array_filter($reviews, function ($review) use ($userId) {
            return $review['user_id'] == $userId; // user_id が一致するもののみ表示
        });

        return view('reviews.mylist', ['reviews' => $reviews]);
    }

    public function destroy(Request $request) // Toshimi 作成
    {
        $reviewId = $request->input('review_id');

        // 仮のダミー処理（本番ではDBから削除）
        // Review::where('id', $reviewId)->delete();

        return redirect()->route('my-reviews.list')->with('success', 'Review deleted successfully.');
    }
}
