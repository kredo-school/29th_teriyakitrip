@extends('layouts.app')

@section('title', 'Show Itinerary')
    
@section('content')

<link rel="stylesheet" href="{{ asset('css/itinerary_header_styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/itinerary_body.css') }}">
<link rel="stylesheet" href="{{ asset('css/itinerary_edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/show_itinerary.css') }}">

<div class="container">
    <div class="row y-0">
        <div class="col-6 w-50 wrapper d-flex flex-column">

            {{-- title, edit done btn --}}
            <div class="row align-items-center mt-3">
                <div class="d-flex align-items-center justify-content-start w-100">
                    <div class="col-auto">
                        <a href="#" class="text-dark">
                            <i class="fa-solid fa-arrow-left fs-2"></i>
                        </a>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <h3>Title Here</h3>
                    </div>
                        
                    <div class="col-auto ms-auto">
                        
                        <a href="{{ route('itineraries.edit_itinerary') }}" method="GET" class="border-0 bg-transparent btn-sm text-decoration-none text-dark">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        
                        
                        
                    </div>
                </div>
            </div>

            {{-- dates, prefectures, avatar --}}
            <div class="row mt-2 g-0">
                    <div class="col-auto">
                        <div class="row">
                            <div class="col-12">
                                    <p class="text-center float-start mb-2">
                                        2025/-/- <strong>-</strong> 2025/-/- <br>
                                        <span class="mt-0">4days</span>
                                    </p>
                            </div>                        
                        </div>
                    </div>
                
                    <div class="col d-flex justify-content-end">
                        <div class="me-2 other-icons">
                            {{-- other member's icon --}}
                            <i class="fa-solid fa-circle-user text-primary icon-md"></i>
                            <i class="fa-solid fa-circle-user text-success icon-md"></i>
                        </div>
                        

                        {{-- Auth icon --}}
                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>

                        {{-- member + btn --}}
                        <i class="fa-solid fa-user-plus icon-sm"></i>
                    </div>
            </div>

            <div class="d-flex flex-wrap gap-1 mb-2">
                <div class="prefecture-box text-center text-dark px-2 round">Okinawa</div>
                <div class="prefecture-box text-center text-dark px-2 round">aichi</div>
                <div class="prefecture-box text-center text-dark px-2 round">aichi</div>
                <div class="prefecture-box text-center text-dark px-2 round">aichi</div>
                <div class="prefecture-box text-center text-dark px-2 round">aichi</div>
            </div>
            
            {{-- overview, day --}}
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide active-tab overview-margin">
                        Overview
                    </div>
                    <div class="swiper-slide"> 
                            Day 1
                    </div>
                    <div class="swiper-slide">
                            Day 2
                    </div>
                    <div class="swiper-slide">
                            Day 3
                    </div>
                    <div class="swiper-slide">
                            Day 4
                    </div>
                </div>

                <!-- 左右のナビゲーションボタン -->
                <div class="swiper-button-prev ms-2"></div>
                <div class="swiper-button-next me-2"></div>

            </div>
                
            
            <div class="mt-4 mb-4 wrapper">
                
                <div class="d-flex align-items-center">
                    <div class="day-box text-center text-light p-2 px-3">Day 1</div>
                </div>
            
                {{-- Day1 8:00am--}}
                <div class="d-flex mt-3">
                    <p class="edit-time mb-0 ms-1">8:00 AM</p>
                </div>
                <div class="card itinerary-card mt-3 align-items-center w-100">
                    <div class="row g-0 w-100 justify-content-center align-items-center">

                        <!-- 左側の画像 -->
                        <div class="col-auto">
                            <img src="{{ asset('images/okinawa-mihama-american-village-38427.jpg') }}" class="rounded img-thumbnail" alt="Place Image">
                        </div>
            
                        <!-- 右側のテキストとアイコン -->
                        <div class="col">
                            <div class="card-body">
                                <h5 class="fw-bold">American Village</h5>
                            </div>
                        </div>
                    </div>
                </div>
            
                {{-- Day1 10:00am --}}
                <div class="d-flex mt-3">
                    <p class="edit-time mb-0 ms-1">10:00 AM</p>
                </div>
                <div class="card itinerary-card mt-2 align-items-center w-100">
                    <div class="row g-0 w-100 justify-content-center align-items-center">
                    <!-- 左側の画像 -->
                    
                        <div class="col-auto">
                            <img src="{{ asset('images/okinawa-mihama-american-village-38427.jpg') }}" class="rounded img-thumbnail" alt="Place Image">
                        </div>
            
                        <!-- 右側のテキストとアイコン -->
                        <div class="col">
                            <div class="card-body">
                                <h5 class="fw-bold">American Village</h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Day2 0:00 pm --}}
                <div class="row">
                    <div class="d-flex align-items-center mt-4">
                        <div class="day-box text-center text-light p-2 px-3">Day 2</div>
                    </div>
                </div>
                <div class="d-flex mt-3">
                    <p class="edit-time mb-0 ms-1">0:00 PM</p>
                </div>
                <div class="card itinerary-card mt-2 align-items-center w-100">
                    <div class="row g-0 w-100 justify-content-center align-items-center">

                        <!-- 左側の画像 -->
                        <div class="col-auto">
                            <img src="{{ asset('images/okinawa-mihama-american-village-38427.jpg') }}" class="rounded img-thumbnail" alt="Place Image">
                        </div>
            
                        <!-- 右側のテキストとアイコン -->
                        <div class="col">
                            <div class="card-body">
                                <h5 class="fw-bold">American Village</h5>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>

        <!-- 右側にGoogle Map -->
        <div class="col-6">
            <div id="map" class="google-map-wrapper"></div>
        </div>

    </div>
</div>

@endsection