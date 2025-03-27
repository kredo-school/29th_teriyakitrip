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
                    <!-- Favorite Itineraries -->
                    <h5 class="mt-4 h3">Favorite Itineraries</h5>
                    <div class="row">
                        @if ($favoriteItineraries->isEmpty())
                            <div class="col-md-12 text-center my-4">
                                <i class="fa-regular fa-folder-open fa-2x text-secondary"></i>
                                <p class="text-muted mt-2">You have no favorite itineraries yet.</p>
                            </div>
                        @else
                            @foreach ($favoriteItineraries as $fav)
                                <div class="col-md-12 mb-3 position-relative">
                                    <div class="card favorite-card d-flex flex-row align-items-center p-2">
                                        <div class="favorite-image-container">
                                            <img src="{{ asset('storage/itineraries/images/' . $fav->itinerary->photo) }}"
                                                class="favorite-image" alt="Itinerary Image">
                                            <!-- お気に入りボタン -->
                                            <form method="POST"
                                                action="{{ route('favorites.toggle.itinerary', $fav->itinerary->id) }}"
                                                class="d-inline position-absolute top-0 end-0 m-2">
                                                @csrf
                                                <button type="submit" class="favorite-btn border-0 bg-transparent">
                                                    @if (FavoriteItinerary::where('user_id', Auth::id())->where('itinerary_id', $fav->itinerary->id)->exists())
                                                        <i class="fa-solid fa-star text-warning"></i> <!-- お気に入り登録済み -->
                                                    @else
                                                        <i class="fa-regular fa-star text-secondary"></i> <!-- お気に入り未登録 -->
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h5 class="card-title">{{ $fav->itinerary->title }}</h5>
                                            <p class="text-muted">Shared by:
                                                {{ $fav->itinerary->user->user_name ?? 'Unknown User' }}</p>
                                        </div>
                                        <div class="text-end mt-auto">
                                            <a href="{{ route('itineraries.editDestination', ['id' => $fav->itinerary->id]) }}"
                                                class="btn view-review-btn btn-sm">View This Itinerary</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Favorite Restaurant Reviews -->
                    <h5 class="mt-4">Favorite Restaurant Reviews</h5>
                    <div class="row">
                        @if ($favoriteRestaurants->isEmpty())
                            <div class="col-md-12 text-center my-4">
                                <i class="fa-regular fa-folder-open fa-2x text-secondary"></i>
                                <p class="text-muted mt-2">You have no favorite restaurant reviews yet.</p>
                            </div>
                        @else
                            @foreach ($favoriteRestaurants as $fav)
                                @php
                                    $review = $fav->review;
                                @endphp
                                @if ($review)
                                    <div class="col-md-12 mb-3 position-relative">
                                        <div class="card favorite-card d-flex flex-row align-items-center p-2">
                                            <div class="favorite-image-container">
                                                @if ($review->photo)
                                                    <img src="{{ Storage::url($review->photo) }}" class="favorite-image"
                                                        alt="Restaurant Image">
                                                @else
                                                    <img src="{{ asset('images/default-restaurant.jpg') }}"
                                                        class="favorite-image" alt="Default Image">
                                                @endif
                                                <!-- お気に入りボタン -->
                                                <form method="POST"
                                                    action="{{ route('favorites.toggle.restaurant', $review->place_id) }}"
                                                    class="d-inline position-absolute top-0 end-0 m-2">
                                                    @csrf
                                                    <button type="submit" class="favorite-btn border-0 bg-transparent">
                                                        @if ($favoriteRestaurants->contains('place_id', $review->place_id))
                                                            <!-- ここでcontainsを使う -->
                                                            <i class="fa-solid fa-star text-warning"></i> <!-- お気に入り登録済み -->
                                                        @else
                                                            <i class="fa-regular fa-star text-secondary"></i>
                                                            <!-- お気に入り未登録 -->
                                                        @endif
                                                    </button>
                                                </form>

                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <h5 class="card-title">
                                                    {{ $review->restaurant_name ?? 'Unknown Restaurant' }}</h5>

                                                <p class="text-warning mb-2">
                                                    @for ($i = 0; $i < $review->rating; $i++)
                                                        <i class="fa-solid fa-circle text-warning"></i>
                                                    @endfor
                                                    @for ($i = $review->rating; $i < 5; $i++)
                                                        <i class="fa-regular fa-circle text-warning"></i>
                                                    @endfor
                                                    ({{ $review->rating }})
                                                </p>

                                                <p class="text-muted mb-2">{{ Str::limit($review->body, 100) }}</p>

                                                <div class="text-end mt-auto">
                                                    <a href="{{ route('reviews.show', ['place_id' => $review->place_id, 'photo' => urlencode($review->photo)]) }}"
                                                        class="btn view-review-btn btn-sm">View This Review</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                </div>

                <!-- Itineraries タブ -->
                <div class="tab-pane fade" id="itinerary">
                    <h5 class="mt-4">Favorite Itineraries</h5>
                    <div class="row">
                        @if ($favoriteItineraries->isEmpty())
                            <div class="col-md-12 text-center my-4">
                                <i class="fa-regular fa-folder-open fa-2x text-secondary"></i>
                                <p class="text-muted mt-2">You have no favorite itineraries yet.</p>
                            </div>
                        @else
                            @foreach ($favoriteItineraries as $fav)
                                <div class="col-md-12 mb-3">
                                    <div class="card favorite-card d-flex flex-row align-items-center p-2">
                                        <div class="favorite-image-container">
                                            <img src="{{ asset('storage/itineraries/images/' . $fav->itinerary->photo) }}"
                                                class="favorite-image" alt="Itinerary Image">
                                        </div>
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <h5 class="card-title">{{ $fav->itinerary->title }}</h5>
                                            <p class="text-muted">Shared by:
                                                {{ $fav->itinerary->user->user_name ?? 'Unknown User' }}</p>
                                            <div class="text-end mt-auto">
                                                <a href="{{ route('itineraries.editDestination', ['id' => $fav->itinerary->id]) }}"
                                                    class="btn view-review-btn btn-sm">View This Itinerary</a>
                                            </div>
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
                        @if ($favoriteRestaurants->isEmpty())
                            <div class="col-md-12 text-center my-4">
                                <i class="fa-regular fa-folder-open fa-2x text-secondary"></i>
                                <p class="text-muted mt-2">You have no favorite restaurant reviews yet.</p>
                            </div>
                        @else
                            @foreach ($favoriteRestaurants as $fav)
                                @php
                                    $review = $fav->review;
                                @endphp
                                @if ($review)
                                    <div class="col-md-12 mb-3 position-relative">
                                        <div class="card favorite-card d-flex flex-row align-items-center p-2">
                                            <div class="favorite-image-container">
                                                @if ($review->photo)
                                                    <img src="{{ Storage::url($review->photo) }}" class="favorite-image"
                                                        alt="Restaurant Image">
                                                @else
                                                    <img src="{{ asset('images/default-restaurant.jpg') }}"
                                                        class="favorite-image" alt="Default Image">
                                                @endif
                                                <!-- お気に入りボタン -->
                                                <form method="POST"
                                                    action="{{ route('favorites.toggle.restaurant', $review->place_id) }}"
                                                    class="d-inline position-absolute top-0 end-0 m-2">
                                                    @csrf
                                                    <button type="submit" class="favorite-btn border-0 bg-transparent">
                                                        @if ($favoriteRestaurants->contains('place_id', $review->place_id))
                                                            <!-- ここでcontainsを使う -->
                                                            <i class="fa-solid fa-star text-warning"></i>
                                                            <!-- お気に入り登録済み -->
                                                        @else
                                                            <i class="fa-regular fa-star text-secondary"></i>
                                                            <!-- お気に入り未登録 -->
                                                        @endif
                                                    </button>
                                                </form>

                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <h5 class="card-title">
                                                    {{ $review->restaurant_name ?? 'Unknown Restaurant' }}</h5>

                                                <!-- レーティング -->
                                                <p class="text-warning mb-2">
                                                    @for ($i = 0; $i < $review->rating; $i++)
                                                        <i class="fa-solid fa-circle text-warning"></i>
                                                    @endfor
                                                    @for ($i = $review->rating; $i < 5; $i++)
                                                        <i class="fa-regular fa-circle text-warning"></i>
                                                    @endfor
                                                    ({{ $review->rating }})
                                                </p>

                                                <p class="text-muted mb-2">{{ Str::limit($review->body, 100) }}</p>

                                                <div class="text-end mt-auto">
                                                    <a href="{{ route('reviews.show', ['place_id' => $review->place_id, 'photo' => urlencode($review->photo)]) }}"
                                                        class="btn view-review-btn btn-sm">View This Review</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
