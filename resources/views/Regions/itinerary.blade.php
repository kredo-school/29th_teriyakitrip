@extends('layouts.app')

@section('title','Regions itinerary')

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
    <div class="row" id="itinerary-list">
        @if ($itineraries->isNotEmpty())
            @foreach ($itineraries as $index => $trip)
                <div class="col-md-12 itinerary-item" style="{{ $index >= 4 ? 'display: none;' : '' }}">
                    <div class="custom-card">
                        <div class="card-image">
                            <img src="{{ asset('storage/itineraries/images/' . $trip->photo) }}" alt="{{ $trip->title }}">
                        </div>
                        <div class="card-content">
                            <h5>{{ $trip->title }}</h5>
                            <p>{{ \Carbon\Carbon::parse($trip->start_date)->format('Y/m/d') }} - {{ \Carbon\Carbon::parse($trip->end_date)->format('Y/m/d') }}</p>
                            
                            <!-- お気に入りボタン -->
                            {{-- <form method="POST"
                                action="{{ route('favorites.toggle.itinerary', $trip->id) }}"
                                class="d-inline position-absolute top-0 end-0 m-2">
                                @csrf
                                <button type="submit" class="favorite-btn border-0 bg-transparent">
                                    @if (FavoriteItinerary::where('user_id', Auth::id())->where('itinerary_id', $trip->id)->exists())
                                        <i class="fa-solid fa-star text-warning"></i> <!-- お気に入り登録済み -->
                                    @else
                                        <i class="fa-regular fa-star text-secondary"></i> <!-- お気に入り未登録 -->
                                    @endif
                                </button>
                            </form> --}}

                            <button class="btn-view-itinerary">View this Itinerary</button>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- 📌 MORE ボタン -->
            <div class="text-center mt-3">
                <button id="load-more-itinerary" class="btn-more">MORE</button>
            </div>
        @else
            <p class="text-center mt-3 text-muted">No Itineraries</p>
        @endif
    </div>
</div>

<br>

<script src="{{ asset('js/region_itinerary.js') }}"></script>
@endsection