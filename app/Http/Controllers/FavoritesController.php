<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        // 🌟 ダミーデータ（後でDBと連携しやすい形）
        $favorites = [
            ['id' => 1, 'title' => '2025 Okinawa Trip', 'image' => 'images/sample2.jpg', 'user' => 'Toshimi'],
            ['id' => 2, 'title' => '2019 Hokkaido Trip', 'image' => 'images/sample3.jpg', 'user' => 'Yuki'],
            ['id' => 3, 'title' => '2025 Miyazaki Trip', 'image' => 'images/sample4.jpg', 'user' => 'Naoki'],
        ];

        return view('favorites.my_favorite', compact('favorites'));
    }

    public function unfavorite($id)
    {
        // 🌟 ここではまだDBを使用しないので、処理なし
        // ダミーとしてリダイレクトだけ行う
        return redirect()->route('favorites.list')->with('success', 'Itinerary removed from favorites.');
    }
}

