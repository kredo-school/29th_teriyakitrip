<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 最初のユーザーを取得
        $user = User::where('username', 'Toshi12345')->first();

        // レビューデータ
        if ($user) {
            Review::create([
                'user_id' => $user->id,
                'restaurant_name' => 'ABC cafe',
                'comment' => 'Fantastic!!!',
                'rating' => 5,
                'image' => 'images/abc_cafe.jpg', // public/images/abc_cafe.jpgに画像を配置
            ]);

            Review::create([
                'user_id' => $user->id,
                'restaurant_name' => 'ICHIBAN Unagi',
                'comment' => 'Recommended',
                'rating' => 4,
                'image' => 'images/unagi.jpg', // public/images/unagi.jpgに画像を配置
                'date' => '2025-04-20',
            ]);

            Review::create([
                'user_id' => $user->id,
                'restaurant_name' => 'ABC Italian',
                'comment' => 'Just okay!',
                'rating' => 3,
                'image' => 'images/italian.jpg', // public/images/italian.jpgに画像を配置
                'date' => '2025-05-10',
            ]);
        }
    }
}
