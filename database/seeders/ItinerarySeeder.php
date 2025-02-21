<?php

namespace Database\Seeders;

use App\Models\Itinerary;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 最初のユーザーを取得
        $user = User::where('username', 'Toshi12345')->first();

        // 旅程データ
        if ($user) {
            Itinerary::create([
                'user_id' => $user->id,
                'title' => '2025 Okinawa Trip',
                'description' => 'Okinawa trip description',
                'image' => 'images/okinawa.jpg', // public/images/okinawa.jpgに画像を配置
                'date' => '2025-03-15',
            ]);

            Itinerary::create([
                'user_id' => $user->id,
                'title' => '2025 Kyoto Trip',
                'description' => 'Kyoto trip description',
                'image' => 'images/kyoto.jpg', // public/images/kyoto.jpgに画像を配置
                'date' => '2025-04-20',
            ]);

            Itinerary::create([
                'user_id' => $user->id,
                'title' => '2025 Karuizawa Trip',
                'description' => 'Karuizawa trip description',
                'image' => 'images/karuizawa.jpg', // public/images/karuizawa.jpgに画像を配置
                'date' => '2025-05-10',
            ]);
        }
    }
}