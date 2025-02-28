@extends('layouts.app')

@section('title','Regions restaurant-review')

@section('content')

<link rel="stylesheet" href="{{ asset('css/regions-style.css') }}">

<br>
<!-- 📌 ヘッダー -->
<header>
    <h1 class="page-title">Hokkaido</h1>
    <br>
    <nav class="nav-tabs">
        <a href="{{ url('/regions/overview') }}" class="{{ request()->is('regions/overview') ? 'active' : '' }}">Overview</a>
        <a href="{{ url('/regions/itinerary') }}" class="{{ request()->is('regions/itinerary') ? 'active' : '' }}">Itinerary</a>
        <a href="{{ url('/regions/restaurant-review') }}" class="{{ request()->is('regions/restaurant-review') ? 'active' : '' }}">Restaurant Review</a>
    </nav>
</header>

<div class="container mt-4">
    <h2 class="fw-bold">Restaurant Review</h2>
    <div class="row" id="restaurant-list">
        @foreach ($allRestaurants as $index => $restaurant)
            <div class="col-md-12 restaurant-item" style="{{ $index >= 4 ? 'display: none;' : '' }}">
                <div class="custom-card">
                    <div class="card-image">
                        <img src="{{ asset('img/' . $restaurant['img']) }}" alt="{{ $restaurant['title'] }}">
                    </div>
                    <div class="card-content">
                        <h5>{{ $restaurant['title'] }}</h5>

                        <!-- ⭐ 評価（星）表示 -->
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $restaurant['rating'])
                                    <span class="star orange">●</span> <!-- オレンジの星 -->
                                @else
                                    <span class="star gray">●</span> <!-- グレーの星 -->
                                @endif
                            @endfor
                        </div>

                        <p>{{ $restaurant['description'] }}</p>
                        <button class="btn-view-itinerary">View this Restaurant</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 📌 MORE ボタン -->
    <div class="text-center mt-3">
        <button id="load-more-restaurant" class="btn-more">MORE</button>
    </div>
</div>



<script>
    let restaurantIndex = 4;
    document.getElementById('load-more-restaurant').addEventListener('click', function() {
        let items = document.querySelectorAll('.restaurant-item');
        for (let i = restaurantIndex; i < restaurantIndex + 4; i++) {
            if (items[i]) {
                items[i].style.display = 'block';
            }
        }
        restaurantIndex += 4;
        if (restaurantIndex >= items.length) {
            this.style.display = 'none';
        }
    });
</script>
<br>

@endsection