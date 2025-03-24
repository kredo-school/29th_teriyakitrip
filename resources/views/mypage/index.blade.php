@extends('layouts.app')
@section('title', 'My Page')

@section('content')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

<div class="container">
    <div class="row">
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
        </div>

        <!-- Tabs -->
        <div class="col-md-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs-mypage" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link-mypage active fs-2" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link-mypage fs-2" id="itineraries-tab" data-bs-toggle="tab" data-bs-target="#itineraries" type="button" role="tab" aria-controls="itineraries" aria-selected="false">Itineraries</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link-mypage fs-2" id="restaurant-reviews-tab" data-bs-toggle="tab" data-bs-target="#restaurant-reviews" type="button" role="tab" aria-controls="restaurant-reviews" aria-selected="false">Restaurant Reviews</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link-mypage fs-2" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="false">Follower</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link-mypage fs-2" id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab" aria-controls="following" aria-selected="false">Following</button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- タブの中身 -->
        <div class="tab-content" id="myTabContent">

            <!-- Overview タブ -->
            <div class="tab-pane fade show active mb-5" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <div class="mt-4 text-center">
                    <p style="color: #E97911; font-size: 3rem; font-weight: bold">Itinerary</p>

                    <div class="container toppage mt-5"> <!-- RECOMMENDED ITINERALIES SECTION -->
                        
                        <div class="row mt-3">
                            @foreach ($itineraries->take(3) as $itinerary) <!-- 3件だけ表示 -->
                                <div class="col-4 mt-2">
                                    <div class="card card-itinerary shadow-sm border-0 w-100 rounded-4 position-relative">
                                        <img src="{{ asset('storage/itineraries/images/' . $itinerary->photo) }}" alt="Itinerary Image" class="element-style rounded-top-4 itinerary-image">

                                        <div class="card-body p-2 mt-2">
                                            <h5 class="card-title mb-1 fw-bold">{{ $itinerary->title }}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    </div><br>
                    
                    <div class="text-center mt-2">
                        <a href="#" class="btn btn-secondary more-tab-button text-white" 
                        data-target="#itineraries"
                        style="border-radius: 5px; padding: 0.5rem 1rem;">
                            MORE
                        </a>
                    </div>
                </div>

                <!-- Restaurant Reviews Section -->
                <div class="mt-4 text-center">
                    <p style="color: #E97911; font-size: 3rem; font-weight: bold">Restaurant's Review</p>
                    <div class="container toppage mt-5"> <!-- RECOMMENDED RESTAURANT REVIEWS SECTION -->
                        <div class="row mt-3">
                            @if($topRestaurantReviews->isNotEmpty())
                                @foreach ($topRestaurantReviews->take(3) as $review) <!-- 最新の3件を取得 -->
                                    <div class="col-md-4"> <!-- 3カラムのレイアウト -->
                                        <div class="card shadow-sm border-0 w-100 rounded-4">
                                            @if ($review->photo)
                                                <img src="{{ Storage::url($review->photo) }}" 
                                                    alt="Restaurant Image" 
                                                    class="element-style rounded-top-4"
                                                    style="width: 100%; height: 200px; object-fit: cover;">
                                                @else
                                            <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 200px; background-color: #f0f0f0; border-radius: 10px 10px 0 0;">
                                                <i class="fa-solid fa-image fa-3x display-1" style="color: #ccc;"></i>
                                            </div>
                                            @endif
                                            <div class="card-body top-review-item p-2">
                                                <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;">
                                                    {{ $review->restaurant_name ?? 'Unknown Restaurant' }} <!-- レストラン名 -->
                                                    <span class="ms-2">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $review->rating)
                                                                <i class="fa-solid fa-circle" style="color: #E97911;"></i>
                                                            @else
                                                                <i class="fa-regular fa-circle text-warning"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                </h6>
                        
                                                <!-- レビュー一覧 -->
                                                <p class="text-start mt-2">{{ Str::limit($review->title, 50) }}</p>
                        
                                                <!-- 詳細ページへのリンク -->
                                                <div class="text-center">
                                                    <a href="#" class="btn more-tab-button" data-target="#restaurant-reviews"
                                                        class="btn btn-link" style="color: #E97911;">
                                                        View this review
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <br>
                                <div class="text-center mt-2">
                                <a href="#" class="btn btn-secondary more-tab-button text-white" 
                                data-target="#restaurant-reviews"
                                style="border-radius: 5px; padding: 0.5rem 1rem;">
                                    MORE
                                </a>
                                </div>
                            @else
                                <p class="text-muted">No Restaurant Review</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- End of tab content -->

            <!-- Itineraries タブ -->
            <div class="tab-pane fade mb-5" id="itineraries" role="tabpanel" aria-labelledby="itineraries-tab">
                <div class="container mt-4">
                    
                    {{-- <p class="text-center" style="color: #E97911; font-size: 3rem; font-weight: bold">Itinerary</p> --}}

                    <!-- ここにダミーデータのまま Itinerary カードを表示 -->
                    <!-- 📜 Itineraries List -->
                    <div class="row">
                        @php
                            $dummyItineraries = [
                            [
                                'title' => '2025 Okinawa Trip1',
                                'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Changchun Shrine > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                                'photo' => 'images/Okinawa_photo1.jpeg'
                            ],
                            [
                                'title' => '2025 Okinawa Trip2',
                                'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                                'photo' => 'images/Okinawa_photo2.jpeg'
                            ],
                            [
                                'title' => '2025 Okinawa Trip3',
                                'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Changchun Shrine > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                                'photo' => 'images/Okinawa_photo3.jpeg'
                            ],
                            [
                                'title' => '2025 Okinawa Trip4',
                                'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Changchun Shrine > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                                'photo' => 'images/Okinawa_photo4.jpeg'
                            ],
                        ];
                        @endphp

                        @foreach ($dummyItineraries as $itinerary)
                            <div class="col-md-12 mb-3">
                                <div class="card" style="border:none; border-radius:10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                    <div class="row g-0">
                                        <div class="col-md-3">
                                            <img src="{{ asset($itinerary['photo']) }}" alt="Itinerary Image" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px 0 0 10px;">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <h5 class="card-title" style="font-size: 1.2rem; font-weight: bold;">{{ $itinerary['title'] }}</h5>
                                                <p class="card-text" style="font-size: 0.8rem; color: #555;">{{ $itinerary['description'] }}</p>
                                                <div class="text-end">
                                                    <a href="#" class="btn btn-sm" style="background-color: #f0f0f0; color: #333; border-radius: 5px; padding: 0.2rem 0.5rem; font-size: 0.7rem; text-decoration: none;">View this itinerary</a>
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

            <!-- Restaurant Reviews タブ -->
            <div class="tab-pane fade mb-5" id="restaurant-reviews" role="tabpanel" aria-labelledby="restaurant-reviews-tab">
                <div class="container mt-4">
                    <div class="row">
                    @if ($restaurantReviews->isNotEmpty())
                        @foreach ($restaurantReviews as $index => $review)
                            <div class="col-md-12 mb-3 review-item" style="display: {{ $index < 5 ? 'block' : 'none' }};">
                                <div class="card" style="border:none; border-radius:10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                                    <div class="row g-0">
                                        <div class="col-md-3">
                                            @if ($review->photo)
                                            <img src="{{ Storage::url($review->photo) }}" alt="Restaurant Image" 
                                                style="width: 100%; height: 220px; object-fit: cover; border-radius: 10px 0 0 10px;">
                                            @else
                                            <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 100%; background-color: #f0f0f0; border-radius: 10px 0 0 10px;">
                                                <i class="fa-solid fa-image fa-3x display-1" style="color: #ccc;"></i>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <h6 style="font-weight: bold; color: #E97911;">
                                                    {{ $review->restaurant_name ?? 'Unknown' }}
                                                </h6>
                                                <h5 class="card-title fw-bold">{{ $review->title }}</h5>
                                                <p class="card-text">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < $review->rating)
                                                            <i class="fas fa-circle" style="color: #E97911;"></i>
                                                        @else
                                                            <i class="far fa-circle" style="color: #E0E0E0;"></i>
                                                        @endif
                                                    @endfor
                                                </p>
                                                <p class="short-text review-text mb-1">{{ Str::limit($review->body, 200) }}</p>
                                                <p class="full-text d-none review-text mb-1">{{ $review->body }}</p>
                                        
                                                @if (Str::length($review->body) > 100)
                                                    <span class="read-more">Read more...</span>
                                                    <span class="read-less d-none">Read less</span>
                                                @endif
                                                <div class="text-end">
                                                    <a href="{{ route('reviews.show', ['place_id' => $review->place_id,'photo' => urlencode($review->photo)]) }}" class="btn btn-sm" 
                                                        style="background-color: #f0f0f0; color: #333; border-radius: 5px; padding: 0.2rem 0.5rem; font-size: 0.7rem; text-decoration: none;">
                                                        View this restaurant
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <button id="loadMore" class="btn btn-secondary" style="border-radius: 5px; padding: 0.5rem 1rem;">MORE</button>
                        </div>        
                    @else
                        <p class="text-center text-muted mt-4">No Restaurant Review</p>
                    @endif
                    </div>
                </div>
            </div>

            <!-- Follower タブ -->
            <div class="tab-pane fade mb-5" id="followers" role="tabpanel" aria-labelledby="followers-tab">
            </div>
        
            <!-- Following タブ -->
            <div class="tab-pane fade mb-5" id="following" role="tabpanel" aria-labelledby="following-tab">
            </div>
        </div>
    </div>
</div>

<!-- JavaScripts -->
<script src="{{ asset('js/mypage.js') }}"></script>

@endsection