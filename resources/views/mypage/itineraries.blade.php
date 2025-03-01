@extends('layouts.app')
@section('title', 'My Page_Itineraries')

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
                            <button class="nav-link-mypage @if($tab == 'itineraries') active @endif fs-2" id="itineraries-tab" data-bs-toggle="tab" data-bs-target="#itineraries-content" type="button" role="tab" aria-controls="itineraries-content" aria-selected="false">Itineraries</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage @if($tab == 'restaurant-reviews') active @endif fs-2" id="restaurant-reviews-tab" data-bs-toggle="tab" data-bs-target="#restaurant-reviews-content" type="button" role="tab" aria-controls="restaurant-reviews-content" aria-selected="false">Restaurant Reviews</button>
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
                <div class="tab-pane fade @if($tab == 'itineraries') show active @endif" id="itineraries-content" role="tabpanel" aria-labelledby="itineraries-tab">
                    <div class="mt-4 text-center">
                        <p style="color: #E97911; font-size: 3rem; font-weight: bold">Itinerary</p>
                        
                    </div>
                </div>
                
        <!-- 📜 Itineraries List -->
        <div class="row">
            @php
                $dummyItineraries = [
                    [
                        'title' => '2025 Okinawa Trip1',
                        'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Changchun Shrine > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                        'photo' => 'images/Okinawa_photo1.jpeg'
                    ],
                    [
                        'title' => '2025 Okinawa Trip2',
                        'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                        'photo' => 'images/Okinawa_photo2.jpeg'
                    ],
                    [
                        'title' => '2025 Okinawa Trip3',
                        'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Changchun Shrine > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                        'photo' => 'images/Okinawa_photo3.jpeg'
                    ],
                    [
                        'title' => '2025 Okinawa Trip4',
                        'description' => '[Day 1] Shakadang Trail, Xiulin Township > Xiaozhuhuilu Trail > Changchun Shrine > Buluowan > Yan zi kou > Jiu qu dong > Baiyang Trail > 瑠璃渓民宿 >',
                        'photo' => 'images/Okinawa_photo4.jpeg'
                    ],
                ];
            @endphp

            @foreach ($dummyItineraries as $itinerary)
                <div class="col-md-12 mb-3">
                    <div class="card" style="border:none; border-radius:10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="{{ asset($itinerary['photo']) }}" alt="Itinerary Image" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px 0 0 10px;">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-size: 1.2rem; font-weight: bold;">{{ $itinerary['title'] }}</h5>
                                    <p class="card-text" style="font-size: 0.8rem; color: #555;">{{ $itinerary['description'] }}</p>
                                    <div class="text-end">
                                        <a href="#" class="btn btn-sm" style="background-color: #f0f0f0; color: #333; border-radius: 5px; padding: 0.2rem 0.5rem; font-size: 0.7rem; text-decoration: none;">View this itinerary</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-secondary" style="border-radius: 5px; padding: 0.5rem 1rem;">MORE</button>
        </div><br><br>
    </div>
</div>
</div>
</div>
</div>
@endsection