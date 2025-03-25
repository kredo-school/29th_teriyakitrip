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

            @foreach ($itineraries as $itinerary)
                <div class="col-4">
                    <div class="card card-itinerary shadow-sm border-0 w-100 rounded-4 position-relative">
                        <img src="{{ asset('storage/itineraries/images/' . $itinerary->photo) }}" alt="Itinerary Image" class="element-style rounded-top-4">

                        @auth
                            <form method="POST" action="#"
                                class="position-absolute top-0 end-0 m-2">
                                @csrf
                                <button type="submit" class="favorite-btn border-0 bg-transparent">
                                    @if ($itinerary['is_favorite'])
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @else
                                        <i class="fa-regular fa-star text-secondary"></i>
                                    @endif
                                </button>
                            </form>
                        @endauth

                        <div class="card-body p-2 mt-2">
                            <h5 class="card-title mb-1 fw-bold">{{ $itinerary->title }}</h5>

                            <!-- ユーザーのアバターと名前を表示 -->
                            <a href="{{ route('mypage.show_others', ['userId' => $itinerary->user_id]) }}" class="d-flex align-items-center mt-2 text-decoration-none text-dark">

                                @if ($itinerary->user && $itinerary->user->avatar)
                                    <img src="{{ Storage::url($itinerary->user->avatar) }}" alt="User Avatar" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 30px; height: 30px;">
                                        <i class="fa-solid fa-user" style="font-size: 18px; color: #666;"></i>
                                    </div>
                                @endif
                                <span class="ms-2">{{ $itinerary->user->user_name }}</span>
                            </a>

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
                        <img src="{{ $restaurant->photo }}" alt="{{ $restaurant->restaurant_name }}" class="rounded-top-4 img-fluid"
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
                                {{ $restaurant->restaurant_name }}
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
                            @if (isset($restaurantReviews[$restaurant->place_id]))
                            @foreach ($restaurantReviews[$restaurant->place_id] as $review)
                                <div class="d-flex align-items-center mb-1">
                                    <div class="me-3">
                                        @if ($review->user->avatar)
                                            <img src="{{ Storage::url($review->user->avatar) }}" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 40px; height: 40px;">
                                                <i class="fa-solid fa-user" style="font-size: 24px; color: #666;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="ms-2">{{ $review->title }}</span>
                                </div>
                            @endforeach
                        @endif

                        <div class="text-center">
                            <a href="{{ route('reviews.show', ['place_id' => $restaurant->place_id, 'photo' => urlencode($restaurant->photo)]) }}" class="btn btn-link text-warning">
                                View more review
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- 🔥 モーダルを読み込む -->
    @include('regions.modal', ['regions' => $regions])
@endsection
