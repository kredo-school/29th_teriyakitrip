@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/top_page.css') }}">
    <div> <!-- BANNER SECTION -->
        <div class="banner" id="banner">
            <div class="banner-text">
                <h2>Welcome to <span>Teriyaki Trip</span></h2>
                <p>Turn every trip into a delicious adventure with Our Teriyaki Trip.</p>
            </div>
        </div>
    </div>

    <div class="region-list-width container-md"> <!-- REGION LIST SECTION -->
        <div class="text-center">
            <div class="h3 mt-3 d-flex flex-wrap justify-content-center text-lg font-semibold fw-bold">
                <a href="{{ route('regions.overview', ['prefecture_id' => 1]) }}"
                    class="mx-2 region-1 region-clickable">Hokkaido</a>
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
                <a href="{{ route('regions.overview', ['prefecture_id' => 47]) }}"
                    class="mx-2 region-10 region-clickable">Okinawa</a>
            </div>
        </div>
    </div>

    <div class="container toppage mt-5"> <!-- RECOMMENDED ITINERARIES SECTION -->
        <h2 class="display-5 text-center fw-bold">Itineraries</h2>
        <div class="row mt-3">

            @php
                // ダミーデータ（DBがないため仮のデータ）
                $itineraries = [
                    [
                        'id' => 1,
                        'title' => '2025 Okinawa Trip',
                        'image' => 'images/sample2.jpg',
                        'is_favorite' => session('favorite_1', false),
                    ],
                    [
                        'id' => 2,
                        'title' => '2019 Hokkaido Trip',
                        'image' => 'images/sample3.jpg',
                        'is_favorite' => session('favorite_2', false),
                    ],
                    [
                        'id' => 3,
                        'title' => '2025 Miyazaki Trip',
                        'image' => 'images/sample4.jpg',
                        'is_favorite' => session('favorite_3', false),
                    ],
                ];
            @endphp

            @foreach ($itineraries as $itinerary)
                <div class="col-4"> <!-- Itinerary カード -->
                    <div class="card shadow-sm border-0 w-100 rounded-4 position-relative">
                        <!-- Itinerary 画像 -->
                        <img src="{{ asset($itinerary['image']) }}" alt="Itinerary Image"
                            class="element-style rounded-top-4">

                        @auth <!-- ログインしている場合のみお気に入り機能を表示 -->
                            <!-- ★ ボタン（画像の右上） -->
                            <form method="POST" action="{{ route('itinerary.favorite', ['id' => $itinerary['id']]) }}"
                                class="position-absolute top-0 end-0 m-2">
                                @csrf
                                <button type="submit" class="favorite-btn border-0 bg-transparent">
                                    @if ($itinerary['is_favorite'])
                                        <i class="fa-solid fa-star text-warning fs-4"></i> <!-- お気に入り登録済み -->
                                    @else
                                        <i class="fa-regular fa-star text-secondary fs-4"></i> <!-- お気に入り未登録 -->
                                    @endif
                                </button>
                            </form>
                        @endauth

                        <div class="card-body p-2">
                            <h6 class="card-title mb-1 fw-bold">{{ $itinerary['title'] }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="container toppage my-5"> <!-- RECOMMENDED RESTAURANT REVIEWS SECTION -->
        <h2 class="display-5 text-center fw-bold">Restaurant Reviews</h2>
        <div class="row mt-3">
            @foreach ($popularRestaurants as $restaurant)
                <div class="col-4">
                    <div class="card shadow-sm border-0 w-100 rounded-4 position-relative">
                        <!-- レストラン画像 -->
                        <img src="{{ $restaurant->photo }}" alt="{{ $restaurant->name }}" class="rounded-top-4 img-fluid"
                            style="height: 200px; object-fit: cover;">

                        @auth <!-- ログインしている場合のみお気に入り機能を表示 -->
                            <!-- ⭐ お気に入りボタン（右上） -->
                            <form method="POST" action="{{ route('favorites.toggle.restaurant', $restaurant->place_id) }}"
                                class="position-absolute top-0 end-0 m-2">
                                @csrf
                                <input type="hidden" name="place_id" value="{{ $restaurant->place_id }}">
                                <button type="submit" class="favorite-btn border-0 bg-transparent">
                                    @if ($restaurant->isFavorite)
                                        <i class="fa-solid fa-star text-warning fs-4"></i> <!-- お気に入り登録済み -->
                                    @else
                                        <i class="fa-regular fa-star text-secondary fs-4"></i> <!-- お気に入り未登録 -->
                                    @endif
                                </button>
                            </form>
                        @endauth

                        <div class="card-body p-2">
                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px;">
                                {{ $restaurant->name }}
                            </h6>
                            <h6>
                                <span class="restaurant-rating">{{ number_format($restaurant->average_rate, 1) }}</span>
                                <span class="ms-2 text-warning">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($restaurant->average_rate))
                                            <i class="fa-solid fa-circle text-warning"></i>
                                        @else
                                            <i class="fa-regular fa-circle text-warning"></i>
                                        @endif
                                    @endfor
                                </span>
                                ({{ $restaurant->review_count }} reviews)
                            </h6>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- 🔥 モーダルを読み込む -->
    @include('regions.modal', ['regions' => $regions])
@endsection
