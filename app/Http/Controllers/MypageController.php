<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Itineraries;
use App\Models\User;

class MypageController extends Controller
{
    public function show($tab = 'overview')
    {
        $user = Auth::user();

        $view = 'mypage_tabs.' . $tab;

        // ビューが存在しない場合は、デフォルトのビューを表示
        if (!view()->exists($view)) {
            $view = 'mypage_tabs.overview';
        }

        if ($tab === 'itineraries') {
            $itineraries = Itineraries::where('user_id', $user->id)->paginate(6);
            return view($view, compact('itineraries', 'user'));
        }

        $data = compact('user');
        if ($tab === 'restaurant_reviews') {
            $reviews = []; // 実際のレビュー取得に変更
            $data = compact('reviews', 'user');
        }

        if ($tab === 'followers') {
            $followers = []; // 実際のフォロワー取得に変更
            $data = compact('followers', 'user');
        }

        if ($tab === 'following') {
            $following = []; // 実際のフォロー中ユーザー取得に変更
            $data = compact('following', 'user');
        }

        return view('index', ['tabContent' => $view, 'data' => $data]);
    }

    public function index()
    {
        return $this->show(); // デフォルトで 'overview' タブを表示
    }
}