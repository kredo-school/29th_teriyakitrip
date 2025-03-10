@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/my_reviews_list.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my_favorites.css') }}">

    <div class="container mt-4">
        <!-- Header -->
        <h3 class="text-start display-6 fw-bold">My Favorite</h3>

        <div class="container">
            <!-- 🔹 Tab Menu -->
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#overview">Overview</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#itinerary">Itineraries</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#restaurant">Restaurant Reviews</a></li>
            </ul>

            <!-- 🔹 すべての tab-pane を tab-content の中に入れる -->
            <div class="tab-content">
                <!-- 🔹 Overview タブ -->
                <div class="tab-pane fade show active" id="overview">
                    <!-- Itineraries -->
                    <h5 class="mt-4 h3">Favorite Itineraries</h5>
                    <div class="row">
                        @if (empty($favoriteItineraries))
                            <p class="text-muted">Your favorite itineraries will appear here.</p>
                        @else
                            <div class="row">
                                @foreach ($favoriteItineraries as $itinerary)
                                    <div class="col-md-12 mb-3 position-relative"> <!-- ✅ mb-3 追加 -->
                                        <div class="card favorite-card d-flex flex-row align-items-center p-2">
                                            <div class="favorite-image-container">
                                                <img src="{{ asset($itinerary['image']) }}" class="favorite-image"
                                                    alt="Itinerary Image">
                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <h5 class="card-title">{{ $itinerary['title'] }}</h5>
                                                <p class="text-muted">Shared by: {{ $itinerary['user'] }}</p>
                                            </div>
                                            <div class="text-end mt-auto">
                                                <a href="#" class="btn view-review-btn btn-sm">View This Itinerary</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <h5 class="mt-4 h3">Favorite Restaurant Reviews</h5>
                    <div class="row">
                        @if (empty($favoriteRestaurants))
                            <p class="text-muted">Your favorite restaurant reviews will appear here.</p>
                        @else
                            <div class="row">
                                @foreach ($favoriteRestaurants as $review)
                                    <div class="col-md-12 position-relative">
                                        <div class="card favorite-card mb-3 d-flex flex-row align-items-center p-2">
                                            <div class="favorite-image-container">
                                                <img src="{{ asset($review['image']) }}" class="favorite-image"
                                                    alt="Restaurant Image">
                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <h5 class="card-title">{{ $review['restaurant'] }}</h5>

                                                <!-- ⭐ レストラン名の右にRatingを表示 -->
                                                <div class="d-flex align-items-center">
                                                    <p class="text-warning mb-0 me-2">
                                                        @for ($i = 0; $i < $review['rating']; $i++)
                                                            <i class="fa-solid fa-circle text-warning"></i>
                                                        @endfor
                                                        @for ($i = $review['rating']; $i < 5; $i++)
                                                            <i class="fa-regular fa-circle text-warning"></i>
                                                        @endfor
                                                        ({{ $review['rating'] }})
                                                    </p>
                                                </div>

                                                <!-- ⭐ ユーザーアイコン + レビュー -->
                                                <div class="review-user-container">
                                                    @if (isset($review['user_avatar']) && !empty($review['user_avatar']))
                                                        <img src="{{ asset($review['user_avatar']) }}"
                                                            class="review-user-avatar" alt="User Avatar">
                                                    @else
                                                        <img src="{{ asset('images/default-avatar.png') }}"
                                                            class="review-user-avatar" alt="Default Avatar">
                                                    @endif
                                                    <p class="text-muted text-truncate" style="max-width: 400px;">
                                                        {{ $review['review'] }}</p>
                                                </div>


                                                <!-- 🔽 右下にボタン配置 -->
                                                <!-- 🔽 右下にボタン配置（ボタンを完全に右寄せ） -->
                                                <div class="mt-auto ms-auto">
                                                    <a href="#" class="btn view-review-btn btn-sm">View This
                                                        Review</a>
                                                </div>

                                            </div>




                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>


                <!-- Itineraries タブ -->
                <div class="tab-pane fade" id="itinerary">
                    <h5 class="mt-4">Favorite Itineraries</h5>
                    <div class="row">
                        @if (empty($favoriteItineraries))
                            <p class="text-muted">Your favorite itineraries will appear here.</p>
                        @else
                            @foreach ($favoriteItineraries as $itinerary)
                                <div class="col-md-12 mb-3">
                                    <div class="card favorite-card">
                                        <div class="favorite-image-container">
                                            <img src="{{ asset($itinerary['image']) }}" class="favorite-image"
                                                alt="Itinerary Image">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $itinerary['title'] }}</h5>
                                            <p class="text-muted">Shared by: {{ $itinerary['user'] }}</p>
                                        </div>
                                        <div class="text-end mt-auto">
                                            <a href="#" class="btn view-review-btn btn-sm">View This Itinerary</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Restaurant Reviews タブ -->
                <div class="tab-pane fade" id="restaurant">
                    <h5 class="mt-4">Favorite Restaurant Reviews</h5>
                    <div class="row">
                        @if (empty($favoriteRestaurants))
                            <p class="text-muted">Your favorite restaurant reviews will appear here.</p>
                        @else
                            @foreach ($favoriteRestaurants as $review)
                                <div class="col-md-12 mb-3">
                                    <div class="card favorite-card">
                                        <div class="favorite-image-container">
                                            <img src="{{ asset($review['image']) }}" class="favorite-image"
                                                alt="Restaurant Image">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $review['restaurant'] }}</h5>
                                            <p class="text-warning">
                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                    <i class="fa-solid fa-circle text-warning"></i>
                                                @endfor
                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                    <i class="fa-regular fa-circle text-warning"></i>
                                                @endfor
                                                ({{ $review['rating'] }})
                                            </p>
                                            <p class="text-muted">{{ $review['review'] }}</p>
                                        </div>
                                        <div class="text-end mt-auto">
                                            <a href="#" class="btn view-review-btn btn-sm">View This Review</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


        </div>

    @endsection
