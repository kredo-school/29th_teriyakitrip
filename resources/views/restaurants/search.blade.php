@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/restaurant_search.css') }}">

<div class="container mt-4">

    <!-- option (when we have time) -->
    <!-- suggest area -->
    <h3 class="text-center fw-bold mb-3">Let's create reviews for the restaurants<span class="break-line">you've added to your itinerary!!</span></h3>
    
    <div class="suggestion-carousel">
        <button class="carousel-prev"><i class="fa-solid fa-angle-left"></i></button>
        
        <div class="suggestion-list">
            <!-- JavaScript で動的に表示 -->
        </div>
        
        <button class="carousel-next"><i class="fa-solid fa-angle-right"></i></button>
    </div>

    <div class="search-bar-container mt-5">
        <input type="text" id="restaurantSearchInput" class="search-bar" placeholder="Search for a restaurant...">
        <button id="searchButton" class="search-button">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>

    <!-- 🔍 結果リスト -->
    <div id="restaurantResults" class="restaurant-list mb-5">
        <!-- JavaScript で検索結果をここに表示 -->
    </div>
</div>

<script src="{{ asset('js/restaurant_search.js') }}"></script>

@endsection
