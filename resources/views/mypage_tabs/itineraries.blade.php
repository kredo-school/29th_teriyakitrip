@extends('layouts.tab_layout')

@section('title', 'Itineraries')

@section('tab-content')
<link rel="stylesheet" href="{{ asset('css/nozomi.css') }}">

<div class="container mt-4">
    <div class="row">
        @foreach ($itineraries as $itinerary)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ Storage::url($itinerary->photo) }}" class="card-img-top" alt="Itinerary Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $itinerary->title }}</h5>
                        <a href="{{ route('itineraries.show', $itinerary->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $itineraries->links() }}
</div>

{{-- <div class="container">
    <div class="row">
        <!-- Profile Header -->
        <div class="col-md-12">
            <div class="card mb-4" style="border: none; border-radius: 10px;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- User Info -->
                        <div class="col-md-6 text-center">
                            @if(isset($user) && auth()->check())
                                <div style="position: relative; display: inline-block; width: 100%; max-width: 300px;">
                                    <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpeg') }}" alt="User Avatar" class="rounded-circle avatar-image" width="100" height="100" style="border: 3px solid #fff; position: absolute; top: 0; left: 50%; transform: translateX(-50%); z-index: 2;">
                                    <div style="background-color: #d3d0d0; padding: 70px 20px 20px; border-radius: 10px; margin-top: 50px; position: relative; min-height: 200px;">
                                        <h5 class="mb-3">{{ $user->user_name }}</h5>
                                        <p class="text-center" style="color: #777; font-size: 0.8em; width: 100%; margin: 0 auto; white-space: pre-wrap; word-wrap: break-word;">{!! nl2br(e($user->introduction)) !!}</p>
                                    </div>
                                </div>
                            @else
                                <p>ユーザー情報が利用できません。ログインしてください。</p>
                            @endif
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
                            <button class="nav-link-mypage fs-2 @if($activeTab == 'overview') active @endif" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="false">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2 @if($activeTab == 'itineraries') active @endif" id="itineraries-tab" data-bs-toggle="tab" data-bs-target="#itineraries" type="button" role="tab" aria-controls="itineraries" aria-selected="true">Itineraries</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2 @if($activeTab == 'restaurant_reviews') active @endif" id="restaurant-reviews-tab" data-bs-toggle="tab" data-bs-target="#restaurant-reviews" type="button" role="tab" aria-controls="restaurant-reviews" aria-selected="false">Restaurant Reviews</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2 @if($activeTab == 'followers') active @endif" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab" aria-controls="followers" aria-selected="false">Follower</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-mypage fs-2 @if($activeTab == 'following') active @endif" id="followed-tab" data-bs-toggle="tab" data-bs-target="#followed" type="button" role="tab" aria-controls="followed" aria-selected="false">Following</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
