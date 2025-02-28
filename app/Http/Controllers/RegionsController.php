<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    // 📌 Overviewページのデータ
    public function overview()
    {
        return view('Regions.home', [
            'allItineraries' => [
                ['img' => 'biei_flower16.jpg', 'title' => '2025 Hokkaido Trip', 'description' => 'Experience the best of Hokkaido.'],
                ['img' => 'OIP.jpg', 'title' => '2023 Hokkaido Trip', 'description' => 'Explore the beauty of Japan’s north.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2022 Hokkaido Trip', 'description' => 'Enjoy the scenic landscapes.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2021 Hokkaido Trip', 'description' => 'Discover hidden gems in Hokkaido.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2020 Hokkaido Trip', 'description' => 'Snowy wonderland adventures.']
            ],
            'allRestaurants' => [
                ['img' => 'what-is-unagi-gettyimages-13043474274x3-7c4d7358c68d48d7ad029159563608d0.jpg', 'title' => 'ICHIBAN Unagi', 'description' => 'Delicious grilled eel with sweet sauce.', 'rating' => 4],
                ['img' => 'download (1).jpg', 'title' => 'ABC Italian', 'description' => 'Authentic Italian pasta with a Japanese twist.', 'rating' => 3],
                ['img' => 'ダウンロード.jpg', 'title' => 'Sapporo Ramen', 'description' => 'Rich miso ramen, a specialty of Sapporo.', 'rating' => 5],
                ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Sushi', 'description' => 'Fresh seafood sushi from the best fish markets.', 'rating' => 2],
                ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Seafood Grill', 'description' => 'Grilled seafood with local ingredients.', 'rating' => 5]
            ]
        ]);
    }

    // 📌 Itineraryページのデータ
    public function itinerary()
    {
        return view('Regions.itinerary', [
            'allItineraries' => [
                ['img' => 'biei_flower16.jpg', 'title' => '2025 Hokkaido Trip', 'description' => 'Enjoy the scenic beauty of Hokkaido.'],
                ['img' => 'OIP.jpg', 'title' => '2023 Hokkaido Trip', 'description' => 'Discover the hidden gems of Japan’s northern island.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2022 Hokkaido Trip', 'description' => 'Snowy landscapes and warm hot springs.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2021 Hokkaido Trip', 'description' => 'Experience the culture and cuisine of Hokkaido.'],
                ['img' => 'k7yn4os6sqfpuott0plx.jpg', 'title' => '2020 Hokkaido Trip', 'description' => 'A journey through Japan’s winter wonderland.']
            ]
        ]);
    }

    // 📌 Restaurant Reviewページのデータ
    public function restaurantReview()
    {
        return view('Regions.restaurant_review', [
            'allRestaurants' => [
                ['img' => 'what-is-unagi-gettyimages-13043474274x3-7c4d7358c68d48d7ad029159563608d0.jpg', 'title' => 'ICHIBAN Unagi', 'description' => 'Delicious grilled eel with sweet sauce.', 'rating' => 4],
                ['img' => 'download (1).jpg', 'title' => 'ABC Italian', 'description' => 'Authentic Italian pasta with a Japanese twist.', 'rating' => 3],
                ['img' => 'ダウンロード.jpg', 'title' => 'Sapporo Ramen', 'description' => 'Rich miso ramen, a specialty of Sapporo.', 'rating' => 5],
                ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Sushi', 'description' => 'Fresh seafood sushi from the best fish markets.', 'rating' => 2],
                ['img' => 'ダウンロード.jpg', 'title' => 'Hokkaido Seafood Grill', 'description' => 'Grilled seafood platter with local flavors.', 'rating' => 5]
            ]
        ]);
    }

}