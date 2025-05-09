{{-- This contents moved to views/maypage/index.blade.php 
I will keep this file just in case by naho--}}
@extends('layouts.app')
@section('title', 'My Page_Overview')

@section('content')
<link rel="stylesheet" href="{{ asset('css/nozomi.css') }}">

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
                            <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpeg') }}" alt="User Avatar" class="rounded-circle avatar-image" width="100" height="100" style="border: 3px solid #fff; position: absolute; top: 0; left: 50%; transform: translateX(-50%); z-index: 2;">
                            <div style="background-color: #d3d0d0; padding: 70px 20px 20px; border-radius: 10px; margin-top: 50px; position: relative; min-height: 200px;">
                                <h5 class="mb-3">{{ $user->user_name }}</h5>
                                <p class="text-center" style="color: #777; font-size: 0.8em; width: 100%; margin: 0 auto; white-space: pre-wrap; word-wrap: break-word;">{!! nl2br(e($user->introduction)) !!}</p>
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

            <!-- Tabs -->
            <div class="col-md-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs-mypage" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage @if($tab == 'overview') active @endif fs-2" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-content" type="button" role="tab" aria-controls="overview-content" aria-selected="true">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('mypage.show', ['tab' => 'itineraries']) }}" 
                                class="nav-link-mypage @if($tab == 'itineraries') active @endif fs-2">
                                 Itineraries
                             </a>
                            {{-- <button class="nav-link-mypage @if($tab == 'itineraries') active @endif fs-2" id="itineraries-tab" data-bs-toggle="tab" data-bs-target="#itineraries-content" type="button" role="tab" aria-controls="itineraries-content" aria-selected="false">Itineraries</button> --}}
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('mypage.show', ['tab' => 'restaurant_reviews']) }}" 
                                class="nav-link-mypage @if($tab == 'restaurant_reviews') active @endif fs-2">
                                 Restaurant Reviews
                            </a>
                            {{-- <button class="nav-link-mypage @if($tab == 'restaurant-reviews') active @endif fs-2" id="restaurant-reviews-tab" data-bs-toggle="tab" data-bs-target="#restaurant-reviews-content" type="button" role="tab" aria-controls="restaurant-reviews-content" aria-selected="false">Restaurant Reviews</button> --}}
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage @if($tab == 'followers') active @endif fs-2" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers-content" type="button" role="tab" aria-controls="followers-content" aria-selected="false">Follower</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage @if($tab == 'following') active @endif fs-2" id="followed-tab" data-bs-toggle="tab" data-bs-target="#followed-content" type="button" role="tab" aria-controls="followed-content" aria-selected="false">Following</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="myTabContent">

                <!-- Itinerary Section -->
                <div class="tab-pane fade @if($tab == 'overview') show active @endif" id="overview-content" role="tabpanel" aria-labelledby="overview-tab">
                    <div class="mt-4 text-center">
                        <p style="color: #E97911; font-size: 3rem; font-weight: bold">Itinerary</p>

                        <div class="container toppage mt-5"> <!-- RECOMMENDED ITINERALIES SECTION -->
                            
                            <div class="row mt-3">
                                <div class="col-4"> <!-- Itinerary 1 -->
                                    <div class="card shadow-sm border-0 w-100 rounded-4">
                                        <img src="/images/sample2.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;"> 2025 Okinawa Trip </h6>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                                <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"> <!-- Itinerary 2 -->
                                    <div class="card shadow-sm border-0 w-100 rounded-4">
                                        <img src="/images/sample3.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;"> 2019 Hokkaido Trip </h6>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                                <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"> <!-- Itinerary 3 -->
                                    <div class="card shadow-sm border-0 w-100 rounded-4">
                                        <img src="/images/sample4.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;"> 2025 Miyazaki Trip </h6>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                                                <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        
                        <div class="text-center mt-2">
                            <a href="{{ route('mypage.show', ['tab' => 'itineraries']) }}" class="btn btn-outline-secondary" 
                                style="color: rgb(104,102,102); border-color: rgb(104,102,102); font-size: 1em; padding: 0.25rem 0.5rem; margin-bottom: 0.5cm;">
                                More
                            </a>
                        </div>
                    </div>

                    <!-- Restaurant Reviews Section -->
                    <div class="mt-4 text-center">
                        <p style="color: #E97911; font-size: 3rem; font-weight: bold">Restaurant's Review</p>
                        {{-- @if($restaurantReviews->isNotEmpty())
                        <div class="row justify-content-center">
                            @foreach ($restaurantReviews as $review)
                                <div class="col-md-4 mb-4">
                                    <div class="card" style="border: none; border-radius: 10px;">
                                        <img src="{{ Storage::url($review->image) }}" alt="Restaurant Review Image" class="card-img-top" style="border-radius: 10px 10px 0 0; object-fit: cover; height: 150px;">
                                        <div class="card-body">
                                            <h5 class="card-title" style="font-size: 1em;">ABC cofe</h5>
                                            <p class="card-text" style="font-size: 0.8em; color: #555;">Fantastic!!</p>
                                        </div>
                                            <div class="card-footer" style="background-color: transparent; border-top: none; padding: 0.5rem;">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <p>まだ実際のレビューがありません。No realistic Restaurant's review yet.</p>
                        @endif --}}

                        <div class="container toppage mt-5"> <!-- RECOMMENDED RESTAURANT REVIEWS SECTION -->
                            <div class="row mt-3">
                                <div class="col-4"> <!-- Restaurant Review 1 -->
                                    <div class="card shadow-sm border-0 w-100 rounded-4">
                                        <img src="/images/sample5.jpeg" alt="Itinerary 1" class="element-style rounded-top-4">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;">  ABC Cafe
                                                <i class="fa-solid fa-circle ms-4" style="color: #E97911;"></i> <i class="fa-solid fa-circle" style="color: #E97911;></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-regular fa-circle text-warning"></i> (3 reviews)</h6>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2">Fantastic!!!</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2">Amazing place</span>
                                            </div>
                                            <div class="text-center">
                                                <a href="reviews.html" class="btn btn-link" style="color: #E97911;">View more review</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"> <!-- Restaurant Review 2 -->
                                    <div class="card shadow-sm border-0 w-100 rounded-4">
                                        <img src="/images/sample6.jpeg" alt="Itinerary 1" class="element-style rounded-top-4">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;">  ABC Cafe
                                                <i class="fa-solid fa-circle ms-4 text-warning"></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-regular fa-circle text-warning"></i> (3 reviews)</h6>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2">Fantastic!!!</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2">Amazing place</span>
                                            </div>
                                            <div class="text-center">
                                                <a href="reviews.html" class="btn btn-link" style="color: #E97911;"">View more review</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"> <!-- Restaurant Review 3 -->
                                    <div class="card shadow-sm border-0 w-100 rounded-4">
                                        <img src="/images/sample7.jpg" alt="Itinerary 1" class="rounded-top-4">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;">  ABC Cafe
                                                <i class="fa-solid fa-circle ms-4 text-warning"></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-solid fa-circle text-warning"></i> <i class="fa-regular fa-circle text-warning"></i> (3 reviews)</h6>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2">Fantastic!!!</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <img src="/images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle" style="width: 40px; height: 40px;">
                                                <span class="ms-2">Amazing place</span>
                                            </div>
                                            <div class="text-center">
                                                <a href="reviews.html" class="btn btn-link" style="color: #E97911;"">View more review</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="text-center mt-2">
                            <a href="{{ route('mypage.show', ['tab' => 'restaurant_reviews']) }}" class="btn btn-outline-secondary" 
                                style="color: rgb(104,102,102); border-color: rgb(104,102,102); font-size: 1em; padding: 0.25rem 0.5rem; margin-bottom: 0.5cm;">
                                More
                            </a>
                        </div>
                    </div>
                </div> <!-- End of tab content -->
            </div><br><br>
        </div>
    </div>
</div>
    
</div>


                    </div><br><br>






                    @endsection