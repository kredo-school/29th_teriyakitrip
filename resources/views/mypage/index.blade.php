@extends('layouts.app')
@section('title', 'My Page')

@section('content')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

<style>
    .nav-tabs-mypage {
        display: flex;
        justify-content: center;
        list-style: none;
        border-bottom: 2px solid #ccc;
        padding-left: 0;
        margin-top: 20px;
        border: none !important;
        box-shadow: none !important;
    }

    .nav-link-mypage {
        background: none;
        border: none;
        font-size: 1.2rem;
        font-weight: bold;
        margin: 0 15px;
        padding: 10px 15px;
        cursor: pointer;
        position: relative;
        color: #333;
    }

    .nav-link-mypage.active {
        color: #e67e22;
    }

    .nav-link-mypage.active::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background-color: #e67e22;
        border-radius: 5px;
    }
</style>

@php
    $tab = $tab ?? 'overview';
@endphp

<div class="container">
    <div class="row">
        <!-- Profile Header -->
        <div class="col-md-12">
            <div class="card mb-4" style="border: none; border-radius: 10px;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- User Info -->
                        <div class="col-md-6 text-center">
                            <div style="position: relative; display: inline-block; width: 100%; max-width: 300px;">
                                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpeg') }}" 
                                     alt="User Avatar" class="rounded-circle avatar-image" width="100" height="100" 
                                     style="border: 3px solid #fff; position: absolute; top: 0; left: 50%; transform: translateX(-50%); z-index: 2;">
                                <div style="background-color: #d3d0d0; padding: 70px 20px 20px; border-radius: 10px; margin-top: 50px; position: relative; min-height: 200px;">
                                    <h5 class="mb-3">{{ $user->user_name }}</h5>
                                    <p class="text-center" style="color: #777; font-size: 0.8em; white-space: pre-wrap;">{!! nl2br(e($user->introduction)) !!}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Map Image -->
                        <div class="col-md-6">
                            <img src="{{ asset('images/map_japan.png') }}" alt="Japan Map" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Tabs -->
            <div class="col-md-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs-mypage" id="mypageTabs">
                        <li class="nav-item">
                            <a href="{{ route('mypage.index', ['tab' => 'overview']) }}" 
                               class="nav-link-mypage fs-2 @if($tab === 'overview') active @endif">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mypage.index', ['tab' => 'itineraries']) }}" 
                               class="nav-link-mypage fs-2 @if($tab === 'itineraries') active @endif">Itineraries</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mypage.index', ['tab' => 'restaurant_reviews']) }}" 
                               class="nav-link-mypage fs-2 @if($tab === 'restaurant_reviews') active @endif">Restaurant Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mypage.index', ['tab' => 'followers']) }}" 
                               class="nav-link-mypage fs-2 @if($tab === 'followers') active @endif">Followers</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mypage.index', ['tab' => 'following']) }}" 
                               class="nav-link-mypage fs-2 @if($tab === 'following') active @endif">Following</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content Area -->
            <div id="mypageContent" class="mt-4">
                @if ($tab === 'overview')
                    <!-- Itinerary Section -->
                    <h2 class="text-center mb-4" style="color: #E97911; font-weight: bold;">Itinerary</h2>
                    <div class="row">
                        @foreach ($topItineraries as $itinerary)
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <img src="{{ asset('images/' . $itinerary->photo) }}" class="rounded-top-4" style="height: 220px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-1">{{ $itinerary->title }}</h6>
                                        <p class="text-muted small">{{ Str::limit($itinerary->description, 100) }}</p>
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpeg') }}" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                            <span class="fw-bold">{{ $user->user_name }}</span>
                                            <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div><br>
                    <div class="text-center mt-2">
                        <a href="{{ route('mypage.index', ['tab' => 'itineraries']) }}" class="btn btn-secondary px-4">MORE</a>
                    </div><br>

                    <!-- Restaurant Review Section -->
                    <h2 class="text-center mt-5 mb-4" style="color: #E97911; font-weight: bold;">Restaurant’s Review</h2>
                    <div class="row">
                        @foreach ($topRestaurantReviews as $review)
                            <div class="col-md-4 mb-3">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <img src="{{ asset('images/' . $review->photo) }}" class="rounded-top-4" style="height: 220px; object-fit: cover;">
                                    <div class="card-body">
                                        <h6 class="fw-bold mb-1">{{ $review->restaurant_name }}</h6>
                                        <p class="text-muted small">{{ $review->body }}</p>
                                        <div class="text-warning mb-2">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="{{ $i < $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('mypage.index', ['tab' => 'restaurant_reviews']) }}" class="btn btn-secondary px-4">MORE</a>
                    </div><br><br>

                    @elseif ($tab === 'itineraries')
                        @include('mypage.itineraries') {{-- 👈 itineraries.blade.php を呼び出す --}}

                    @elseif ($tab === 'restaurant_reviews')
                        <h2 class="text-center text-warning">Restaurant Reviews</h2>
                        <div class="row">
                            @foreach ($restaurantReviews as $review)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm border-0 rounded-4">
                                        <img src="{{ asset('images/' . $review->photo) }}" alt="Restaurant" class="rounded-top-4" style="height: 200px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="fw-bold">{{ $review->restaurant_name ?? 'Restaurant' }}</h6>
                                            <p class="small">{{ Str::limit($review->body, 100) }}</p>
                                            <p class="text-warning mb-0">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="{{ $i < $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                @endfor
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                @elseif ($tab === 'followers' || $tab === 'following')
                    <p class="text-muted text-center mt-4">Coming Soon...</p>

                @else
                    <p class="text-danger text-center mt-4">Invalid tab.</p>
                @endif
            </div>

    </div>
</div>
@endsection