@extends('layouts.app')

@section('title','Regions overview')

@section('content')

<link rel="stylesheet" href="{{ asset('css/regions-style.css') }}">


    <br>

    <header>
        <h1 class="page-title">Hokkaido</h1>
        <br>
        <!-- ナビゲーションバー -->
        <nav class="nav-tabs">
            <a href="{{ url('/regions/overview') }}" class="{{ request()->is('regions/overview') ? 'active' : '' }}">Overview</a>
            <a href="{{ url('/regions/itinerary') }}" class="{{ request()->is('regions/itinerary') ? 'active' : '' }}">Itinerary</a>
            <a href="{{ url('/regions/restaurant-review') }}" class="{{ request()->is('regions/restaurant-review') ? 'active' : '' }}">Restaurant Review</a>
        </nav>

    </header>

    <main class="container mt-4">
        
        <!-- 📌 Itinerary セクション -->
        <h2 class="mt-4 fw-bold">Itinerary</h2>
        <div class="row">
            @foreach (array_slice($allItineraries, 0, 2) as $trip)
            <div class="col-md-12">
                <div class="custom-card">
                    <div class="card-image">
                        <img src="{{ asset('img/' . $trip['img']) }}" alt="{{ $trip['title'] }}">
                    </div>
                    <div class="card-content">
                        <h5>{{ $trip['title'] }}</h5>
                        <p>{{ $trip['description'] }}</p>
                        <button class="btn-view-itinerary">View this Itinerary</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ url('/regions/itinerary') }}" class="btn-more">MORE</a>
        </div>

        <!-- 📌 Restaurant Review セクション -->
        <h2 class="mt-5 fw-bold">Restaurant’s Review</h2>
        <div class="row">
            @foreach (array_slice($allRestaurants, 0, 2) as $restaurant)
            <div class="col-md-12">
                <div class="custom-card">
                    <div class="card-image">
                        <img src="{{ asset('img/' . $restaurant['img']) }}" alt="{{ $restaurant['title'] }}">
                    </div>
                    <div class="card-content">
                        <h5>{{ $restaurant['title'] }}</h5>

                        <!-- ⭐ 評価を表示する部分 ⭐ -->
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
        <div class="text-center mt-3">
            <a href="{{ url('/regions/restaurant-review') }}" class="btn-more">MORE</a>
        </div>
    </main>
<br>
@endsection
