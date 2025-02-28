@extends('layouts.app')
@section('title', 'My Page')

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
                            <button class="nav-link-mypage active fs-2" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2" id="itineraries-tab" data-bs-toggle="tab" data-bs-target="#itineraries" type="button" role="tab" aria-controls="itineraries" aria-selected="false">Itineraries</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2" id="restaurant-reviews-tab" data-bs-toggle="tab" data-bs-target="#restaurant-reviews" type="button" role="tab" aria-controls="restaurant-reviews" aria-selected="false">Restaurant Reviews</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="false">10 Followers</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2" id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab" aria-controls="following" aria-selected="false">56 Following</button>
                        </li>
                    </ul>
                </div>
            </div>

                <div class="tab-content" id="myTabContent">
                    <!-- Itineraries Section -->
                    <div class="container">
                    <div class="mt-4 text-center">
                        <p style="color: #E97911; font-size: 3rem; font-weight: bold">Itinerary</p>
                        @if($itineraries->isNotEmpty())
                        <div class="row justify-content-center">
                            @foreach ($itineraries as $itinerary)
                                <div class="col-md-4 mb-4">
                                    <div class="card" style="border: none; border-radius: 10px;">
                                        @if($itinerary->photo)
                                            <img src="{{ Storage::url($itinerary->photo) }}" alt="Itinerary Image" class="card-img-top" style="border-radius: 10px 10px 0 0; object-fit: cover; height: 150px;">
                                        @else
                                            <div class="card-img-top bg-secondary" style="border-radius: 10px 10px 0 0; height: 150px;"></div>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title" style="font-size: 1em;">{{ $itinerary->title }}</h5>
                                            @php
                                                $startDate = $itinerary->start_date;
                                                $endDate = $itinerary->end_date;
                                                $dayCount = $startDate && $endDate ? $startDate->diffInDays($endDate) + 1 : 0;
                                            @endphp

                                            <p class="card-text" style="font-size: 0.8em; color: #555;">
                                                @if($dayCount > 0)
                                                    @for($i = 1; $i <= $dayCount; $i++)
                                                        Day{{ $i }}{{ $i < $dayCount ? ' > ' : '' }}
                                                    @endfor
                                                @else
                                                    日程未定
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <p>まだ旅程がありません。No Itineraries yet.</p>
                        @endif
                        
                        <div class="text-center mt-2">
                                <button class="btn btn-outline-secondary" style="color: #000000; border-color: #000000; font-size: 1em; padding: 0.25rem 0.5rem; margin-bottom: 0.5cm;">More</button>
                        </div>
                    </div>

                    <!-- Restaurant Reviews Section -->
                    <div class="mt-4 text-center">
                        <p style="color: #E97911; font-size: 3rem; font-weight: bold">Restaurant's Review</p>
                        @if($restaurantReviews->isNotEmpty())
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
                            <p>まだレビューがありません。No Restaurant's review yet.</p>
                        @endif

                        <div class="text-center mt-2">
                            <button class="btn btn-outline-secondary" style="color: #000000; border-color: #000000; font-size: 1em; padding: 0.25rem 0.5rem; margin-bottom: 0.5cm;">More</button>
                        </div>
                    </div>
                </div> <!-- End of tab content -->
            </div><br><br>
        </div>
    </div>
</div>
    
</div>
@endsection