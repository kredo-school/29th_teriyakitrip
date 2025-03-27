@extends('layouts.app')

@section('title','Regions restaurant-review')

@section('content')

<link rel="stylesheet" href="{{ asset('css/regions-style.css') }}">

<br>
<!-- 📌 ヘッダー -->
<header>
    <h1 class="page-title">{{ $prefecture->name }}</h1>
    <br>
    <nav class="nav-tabs">
        <a href="{{ route('regions.overview', ['prefecture_id' => $prefecture->id]) }}"
            class="{{ request()->is('regions/'.$prefecture->id.'/overview') ? 'active' : '' }}">Overview</a>
        <a href="{{ route('regions.itinerary', ['prefecture_id' => $prefecture->id]) }}" 
            class="{{ request()->is('regions/'.$prefecture->id.'/itinerary') ? 'active' : '' }}">Itinerary</a>
        <a href="{{ route('regions.restaurant-review', ['prefecture_id' => $prefecture->id]) }}"
            class="{{ request()->is('regions/'.$prefecture->id.'/restaurant-review') ? 'active' : '' }}">Restaurant Review</a>
    </nav>
</header>

<div class="container mt-4">
    @if (count($allRestaurants) > 0)
        <div id="restaurant-list">
            @foreach ($allRestaurants as $restaurant)
                <div class="restaurant-item" style="{{ $loop->index >= 4 ? 'display: none;' : '' }}">
                    <div class="custom-card">
                        <div class="card-image d-flex justify-content-center align-items-center">
                            <img src="{{ $restaurant->photo }}" 
                            alt="{{ $restaurant->restaurant_name }}" 
                            class="rounded img-fluid">
                        </div>
                        <div class="card-content ms-3">
                            
                            <h5>{{ $restaurant->restaurant_name }}</h5>
                            
                            <!-- ⭐ 評価（星）表示 -->
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-2 fs-5">{{ number_format($restaurant->average_rate, 1) }}</span>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($restaurant->average_rate))
                                            <i class="fa-solid fa-circle review-circle orange m-1 fs-5"></i>
                                        @else
                                            <i class="fa-solid fa-circle review-circle gray m-1 fs-5"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <!-- お気に入りボタン -->
                            {{-- <form method="POST"
                                action="{{ route('favorites.toggle.restaurant', $restaurant->place_id) }}"
                                class="d-inline position-absolute top-0 end-0 m-2">
                                @csrf
                                <button type="submit" class="favorite-btn border-0 bg-transparent">
                                    @if (App\Models\FavoriteRestaurant::where('user_id', Auth::id())->where('place_id', $restaurant->place_id)->exists())
                                        <i class="fa-solid fa-star text-warning"></i> <!-- お気に入り登録済み -->
                                    @else
                                        <i class="fa-regular fa-star text-secondary"></i> <!-- お気に入り未登録 -->
                                    @endif
                                </button>
                            </form> --}}

                            <p class="text-muted mb-2">{{ Str::limit($restaurant->description, 100) }}</p>
                            <a href="{{ route('reviews.show', ['place_id' => $restaurant->place_id, 'photo' => urlencode($restaurant->photo)]) }}" class="btn-view-itinerary mt-3">
                                View this Restaurant
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- 📌 MORE ボタン -->
        <div class="text-center mt-3">
            <button id="load-more-restaurant" class="btn-more">MORE</button>
        </div>
    @else
        <p class="text-center mt-5 text-muted">No Restaurant Review</p>
    @endif
</div>

<script src="{{ asset('js/region_restaurant.js') }}"></script>
@endsection
