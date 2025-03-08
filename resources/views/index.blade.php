@extends('layouts.app')

@section('content')
<div class="container">
    <!-- タブナビゲーション -->
    <div class="col-md-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs-mypage" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link-mypage fs-2 @if(request()->route('tab') == 'overview' || request()->route('tab') == null) active @endif" 
                            id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" 
                            aria-controls="overview" aria-selected="true"
                            onclick="window.location.href='{{ route('mypage.show', ['tab' => 'overview']) }}'">
                        Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link-mypage fs-2 @if(request()->route('tab') == 'itineraries') active @endif" 
                            id="itineraries-tab" data-bs-toggle="tab" data-bs-target="#itineraries" type="button" role="tab" 
                            aria-controls="itineraries" aria-selected="false"
                            onclick="window.location.href='{{ route('mypage.show', ['tab' => 'itineraries']) }}'">
                        Itineraries
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link-mypage fs-2 @if(request()->route('tab') == 'restaurant_reviews') active @endif" 
                            id="restaurant-reviews-tab" data-bs-toggle="tab" data-bs-target="#restaurant-reviews" type="button" role="tab" 
                            aria-controls="restaurant-reviews" aria-selected="false"
                            onclick="window.location.href='{{ route('mypage.show', ['tab' => 'restaurant_reviews']) }}'">
                        Restaurant Reviews
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link-mypage fs-2 @if(request()->route('tab') == 'followers') active @endif" 
                            id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" 
                            aria-controls="followers" aria-selected="false"
                            onclick="window.location.href='{{ route('mypage.show', ['tab' => 'followers']) }}'">
                        Followers
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link-mypage fs-2 @if(request()->route('tab') == 'following') active @endif" 
                            id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab" 
                            aria-controls="following" aria-selected="false"
                            onclick="window.location.href='{{ route('mypage.show', ['tab' => 'following']) }}'">
                        Following
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
