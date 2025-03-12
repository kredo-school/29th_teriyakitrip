@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/my_favorites.css') }}">

    <div class="container mt-4">
        <h2 class="fw-bold">My Favorites</h2>

        <!-- 🔹 Tab Menu -->
        <ul class="nav nav-tabs" id="favoritesTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#overview">Overview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#itinerary">Itineraries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#restaurant">Restaurant Reviews</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- 🔹 Overview タブ -->
            <div class="tab-pane fade show active" id="overview">
                <!-- Itineraries -->
                <h5 class="mt-4">Favorite Itineraries</h5>
                <div class="row">
                    @if (empty($favoriteItineraries))
                        <p class="text-muted">Your favorite itineraries will appear here.</p>
                    @else
                        <div class="row">
                            @foreach ($favoriteItineraries as $itinerary)
                                <div class="col-md-12 position-relative">
                                    <div class="card favorite-card">
                                        <div class="favorite-image-container">
                                            <img src="{{ asset($itinerary['image']) }}" class="favorite-image" alt="Itinerary Image">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $itinerary['title'] }}</h5>
                                            <p class="text-muted">Shared by: {{ $itinerary['user'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif <!-- ここで if 文を閉じる -->

                    <div class="text-end mt-2">
                        <a href="#itinerary" class="btn more-btn btn-sm" data-bs-toggle="tab">More Itineraries</a>
                    </div>

                    <!-- Restaurant Reviews -->
                    <h5 class="mt-4">Favorite Restaurant Reviews</h5>

                    @if (empty($favoriteRestaurants))
                        <p class="text-muted">Your favorite restaurant reviews will appear here.</p>
                    @else
                        <div class="row">
                            @foreach ($favoriteRestaurants as $review)
                                <div class="col-md-12">
                                    <div class="card favorite-card">
                                        <!-- 画像 -->
                                        <div class="favorite-image-container">
                                            <img src="{{ asset($review['image']) }}" class="favorite-image" alt="Restaurant Image">
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
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif <!-- ここで if 文を閉じる -->
                </div>

                <div class="text-end mt-2">
                    <a href="#restaurant" class="btn more-btn btn-sm" data-bs-toggle="tab">More Reviews</a>
                </div>
            </div>
        </div>
    </div>
@endsection

