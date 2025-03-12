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
        @foreach ($allItineraries as $index => $trip)
            <div class="col-md-12 itinerary-item" style="{{ $index >= 4 ? 'display: none;' : '' }}">
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

    <!-- 📌 MORE ボタン -->
    <div class="text-center mt-3">
        <button id="load-more-itinerary" class="btn-more">MORE</button>
    </div>
</div>

<script>
    let itineraryIndex = 4;
    document.getElementById('load-more-itinerary').addEventListener('click', function() {
        let items = document.querySelectorAll('.itinerary-item');
        for (let i = itineraryIndex; i < itineraryIndex + 4; i++) {
            if (items[i]) {
                items[i].style.display = 'block';
            }
        }
        itineraryIndex += 4;
        if (itineraryIndex >= items.length) {
            this.style.display = 'none';
        }
    });
</script>
<br>
@endsection

