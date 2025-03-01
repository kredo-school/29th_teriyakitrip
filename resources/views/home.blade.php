@extends('layouts.app')

@section('content')
    {{-- <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>
    <h1 class="text-center">Google Map Test</h1>
    <div id="map"></div> --}}

    <link rel="stylesheet" href="{{ asset('css/top_page.css') }}">
    <div> <!-- BANNER SECTION -->
        <div class="banner" id="banner">
            <div class="banner-text">
                <h2>Welcome to <span>Teriyaki Trip</span></h2>
                <p>Try our tasty coffee been, produced with unique taste</p>
            </div>
        </div>
    </div>

    <div class="region-list-width container-md"> <!-- REGION LIST SECTION -->
        <div class="text-center">
            <div class="h3 mt-3 d-flex flex-wrap justify-content-center text-lg font-semibold fw-bold">
                <span class="mx-2 region-1 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalHokkaido">Hokkaido</span>
                <span class="mx-2 region-2 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalTohoku">Tohoku</span>
                <span class="mx-2 region-3 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalKanto">Kanto</span>
                <span class="mx-2 region-4 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalTokai">Tokai</span>
                <span class="mx-2 region-5 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalHokuriku">Hokuriku</span>
                <span class="mx-2 region-6 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalKinki">Kinki</span>
                <span class="mx-2 region-7 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalChugoku">Chugoku</span>
                <span class="mx-2 region-8 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalShikoku">Shikoku</span>
                <span class="mx-2 region-9 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalKyushu">Kyushu</span>
                <span class="mx-2 region-10 region-clickable" data-bs-toggle="modal"
                    data-bs-target="#regionModalOkinawa">Okinawa</span>
            </div>
        </div>
    </div>


    <div class="container toppage mt-5"> <!-- RECOMMENDED ITINERALIES SECTION -->
        <h2 class="display-5 text-center fw-bold">Itineraries</h2>
        <div class="row mt-3">
            <div class="col-4"> <!-- Itinerary 1 -->
                <div class="card shadow-sm border-0 w-100 rounded-4">
                    <img src="images/sample2.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Okinawa Trip </h6>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                            <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4"> <!-- Itinerary 2 -->
                <div class="card shadow-sm border-0 w-100 rounded-4">
                    <img src="images/sample3.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2019 Hokkaido Trip </h6>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                            <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4"> <!-- Itinerary 3 -->
                <div class="card shadow-sm border-0 w-100 rounded-4">
                    <img src="images/sample4.jpg" alt="Itinerary 1" class="element-style rounded-top-4">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> 2025 Miyazaki Trip </h6>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2 fw-bold">Toshimi's Japan'</span>
                            <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container toppage mt-5"> <!-- RECOMMENDED RESTAURANT REVIEWS SECTION -->
        <h2 class="display-5 text-center fw-bold">Restaurant Reviews</h2>
        <div class="row mt-3">
            <div class="col-4"> <!-- Restaurant Review 1 -->
                <div class="card shadow-sm border-0 w-100 rounded-4">
                    <img src="images/sample5.jpeg" alt="Itinerary 1" class="element-style rounded-top-4">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> ABC Cafe
                            <i class="fa-solid fa-circle ms-4 text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-regular fa-circle text-warning"></i> (3 reviews)
                        </h6>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2">Fantastic!!!</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2">Amazing place</span>
                        </div>
                        <div class="text-center">
                            <a href="reviews.html" class="btn btn-link text-warning">View more review</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4"> <!-- Restaurant Review 2 -->
                <div class="card shadow-sm border-0 w-100 rounded-4">
                    <img src="images/sample6.jpeg" alt="Itinerary 1" class="element-style rounded-top-4">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> ABC Cafe
                            <i class="fa-solid fa-circle ms-4 text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-regular fa-circle text-warning"></i> (3 reviews)
                        </h6>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2">Fantastic!!!</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2">Amazing place</span>
                        </div>
                        <div class="text-center">
                            <a href="reviews.html" class="btn btn-link text-warning">View more review</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4"> <!-- Restaurant Review 3 -->
                <div class="card shadow-sm border-0 w-100 rounded-4">
                    <img src="images/sample7.jpg" alt="Itinerary 1" class="rounded-top-4">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;"> ABC Cafe
                            <i class="fa-solid fa-circle ms-4 text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-solid fa-circle text-warning"></i> <i
                                class="fa-regular fa-circle text-warning"></i> (3 reviews)
                        </h6>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2">Fantastic!!!</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="images/user-icon.jpg" alt="ユーザーアイコン" class="rounded-circle"
                                style="width: 40px; height: 40px;">
                            <span class="ms-2">Amazing place</span>
                        </div>
                        <div class="text-center">
                            <a href="reviews.html" class="btn btn-link text-warning">View more review</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
