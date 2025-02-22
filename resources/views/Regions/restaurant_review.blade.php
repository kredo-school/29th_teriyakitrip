@extends('layouts.app')

@section('title', 'Restaurant Review')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold">Restaurant Review</h2>
    <div class="row">
        @foreach ($allRestaurants as $restaurant)
        <div class="col-md-12">
            <div class="custom-card">
                <div class="card-image">
                    <img src="{{ asset('img/' . $restaurant['img']) }}" alt="{{ $restaurant['title'] }}">
                </div>
                <div class="card-content">
                    <h5 class="fw-bold">{{ $restaurant['title'] }}</h5>
                    
                    <!-- ⭐ 五段階評価を表示 -->
                    <div class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $restaurant['rating'])
                                <span class="rating-circle filled"></span>  <!-- オレンジの丸 -->
                            @else
                                <span class="rating-circle"></span>  <!-- グレーの丸 -->
                            @endif
                        @endfor
                    </div>

                    <p>{{ $restaurant['description'] }}</p>
                    <button class="btn-view-itinerary">View this restaurant</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection