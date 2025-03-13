@extends('layouts.app')

@section('title', "Restaurant's Reviews")

@section('content')
<link rel="stylesheet" href="{{ asset('css/nozomi.css') }}">

<div class="container">    <div class="row">
        <!-- Profile Header -->
        <div class="col-md-12">
            <div class="card mb-4" style="border: none; border-radius: 10px;">
                <div class="card-body">
                    <div class="row align-items-center">
                       <!-- User Info -->
                       <div class="col-md-6 text-center">
                            <div style="position: relative; display: inline-block; width: 100%; max-width: 300px;">
                                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpeg') }}" alt="User Avatar" class="rounded-circle avatar-image" width="100" height="100" style="border: 3px solid #fff; position: absolute; top: 0; left: 50%; transform: translateX(-50%); z-index: 2;">
                                <div style="background-color: #d3d0d0; padding: 70px 20px 20px; border-radius: 10px; margin-top: 50px; position: relative; min-height: 200px;">
                                    <h5 class="mb-3">{{ $user->user_name }}</h5>
                                    <p class="text-center" style="color: #777; font-size: 0.8em; width: 100%; margin: 0 auto; white-space: pre-wrap; word-wrap: break-word;">{!! nl2br(e($user->introduction)) !!}</p>
                                </div>
                            </div>
                        </div>


                        <!-- Map Image -->
                        <div class="col-md-6">
                            <img src="{{ asset('images/map_japan.png') }}" alt="Japan Map" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="col-md-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs-mypage" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('mypage.show', ['tab' => 'overview']) }}" 
                                class="nav-link-mypage @if($tab == 'overview') active @endif fs-2">
                                 Overview
                             </a>
                            {{-- <button class="nav-link-mypage fs-2" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-content" type="button" role="tab" aria-controls="overview-content" aria-selected="false">Overview</button> --}}
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('mypage.show', ['tab' => 'itineraries']) }}" 
                                class="nav-link-mypage @if($tab == 'itineraries') active @endif fs-2">
                                 Itineraries
                             </a>
                            {{-- <button class="nav-link-mypage fs-2" id="itineraries-tab" data-bs-toggle="tab" data-bs-target="#itineraries-content" type="button" role="tab" aria-controls="itineraries-content" aria-selected="false">Itineraries</button> --}}
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage active fs-2" id="restaurant-reviews-tab" data-bs-toggle="tab" data-bs-target="#restaurant-reviews-content" type="button" role="tab" aria-controls="restaurant-reviews-content" aria-selected="true">Restaurant Reviews</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers-content" type="button" role="tab" aria-controls="followers-content" aria-selected="false">Follower</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2" id="followed-tab" data-bs-toggle="tab" data-bs-target="#followed-content" type="button" role="tab" aria-controls="followed-content" aria-selected="false">Following</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="myTabContent">
                <!-- Restaurant's Review Section -->
                <div class="tab-pane fade show active" id="restaurant-reviews-content" role="tabpanel" aria-labelledby="restaurant-reviews-tab">
                    <div class="mt-4 text-center">
                        <p style="color: #E97911; font-size: 3rem; font-weight: bold">Restaurant's Reviews</p>
                    </div>
                </div>
                
        <!-- 📜 レビュー一覧 -->
        <div class="row">
            @php
                $dummyReviews = [
                    ['title' => 'Hokkaido Uni-Ikura-Don!', 'rating' => 3, 'body' => 'I really wanted to eat Sushi and tempura. I went to "Yokota" A luxurious restaurant where you can enjoy both Sushi and tempura. They check that you have finished each dish before serving it to you. Is it suitable for business dinners? This is a great restaurant where you can eat both Sushi and tempura. We had delicious. Thank you for the meal.', 'photo' => 'images/restaurant_photo1.jpeg'],
                    ['title' => 'ABC Cafe', 'rating' => 2, 'body' => 'I really wanted to eat Sushi and tempura. I went to "Yokota" A luxurious restaurant where you can enjoy both Sushi and tempura. They check that you have finished each dish before serving it to you. Is it suitable for business dinners?', 'photo' => 'images/restaurant_photo2.jpeg'],
                    ['title' => 'ICHIBAN Unagi', 'rating' => 4, 'body' => 'I really wanted to eat Sushi and tempura. I went to "Yokota" A luxurious restaurant where you can enjoy both Sushi and tempura. They check that you have finished each dish before serving it to you. Is it suitable for business dinners? This is a great restaurant where you can eat both Sushi and tempura. We had delicious. Thank you for the meal.', 'photo' => 'images/restaurant_photo3.jpeg'],
                    ['title' => 'ABC Italian', 'rating' => 1, 'body' => 'I really wanted to eat Sushi and tempura. I went to "Yokota" A luxurious restaurant where you can enjoy both Sushi and tempura. They check that you have finished each dish before serving it to you.', 'photo' => 'images/restaurant_photo4.jpeg'],
                ];
            @endphp

            @foreach ($dummyReviews as $review)
            <div class="col-md-12 mb-3">
                <div class="card" style="border:none; border-radius:10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{ asset($review['photo']) }}" alt="Restaurant Image" style="width: 100%; height: auto; max-height: 220px; object-fit: cover; border-radius: 10px 0 0 10px;">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title" style="font-size: 1.2rem; font-weight: bold;">{{ $review['title'] }}</h5>
                                <p class="card-text">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $review['rating'])
                                            <i class="fas fa-circle" style="color: #E97911;"></i>
                                        @else
                                            <i class="far fa-circle" style="color: #E0E0E0;"></i>
                                        @endif
                                    @endfor
                                </p>
                                <p class="card-text" style="font-size: 0.8rem; color: #555;">{{ $review['body'] }}</p>
                                <div class="text-end">
                                    <a href="#" class="btn btn-sm" style="background-color: #f0f0f0; color: #333; border-radius: 5px; padding: 0.2rem 0.5rem; font-size: 0.7rem; text-decoration: none;">View this restaurant</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-3">
            <button class="btn btn-secondary" style="border-radius: 5px; padding: 0.5rem 1rem;">MORE</button>
        </div><br><br>
    </div>
</div>
@endsection