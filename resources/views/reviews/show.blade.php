@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/view_review.css') }}">
    <div class="container my-5 px-4">
        <!-- レストラン情報 -->
        <div class="restaurant-header row">
            <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <!-- レストラン名・価格帯 -->
                <div class="col-12 col-md-8 text-md-start text-center mb-2 mb-md-0">
                    <h1 class="restaurant-title d-inline">{{ $restaurant['name'] }}</h1>

                    @php
                        use App\Models\RestaurantReview; // RestaurantReview モデルをインポート
                    @endphp

                </div>

                <!-- レビュー数・評価・お気に入り -->
                <div class="col-12 col-md-4">
                    <div class="row">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-end">
                            <span class="me-md-3 fs-5">{{ $reviewCount }} reviews</span>
                            <span class="restaurant-rating">{{ number_format($averageRating, 1) }}</span>
                            <div class="ms-md-2 my-2 my-md-0">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($averageRating))
                                        <i class="fa-solid fa-circle review-circle"></i>
                                    @else
                                        <i class="fa-regular fa-circle review-circle"></i>
                                    @endif
                                @endfor
                            </div>
                            <!-- お気に入りボタン -->
                            @auth
                                <form method="POST" action="{{ route('favorites.toggle.restaurant', $restaurant['place_id']) }}"
                                    class="d-inline ms-3">
                                    @csrf
                                    <button type="submit" class="favorite-btn border-0 bg-transparent">
                                        @php
                                            // RestaurantReviewインスタンスを取得
                                            $restaurantReview = RestaurantReview::where(
                                                'place_id',
                                                $restaurant['place_id'],
                                            )->first();
                                        @endphp
                                        @if ($restaurantReview && $restaurantReview->isFavorite())
                                            <!-- ここで isFavorite メソッドを呼び出し -->
                                            <i class="fa-solid fa-star text-warning"></i> <!-- お気に入り登録済み -->
                                        @else
                                            <i class="fa-regular fa-star text-secondary"></i> <!-- お気に入り未登録 -->
                                        @endif
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                    <!-- レビュー作成ボタン -->
                    <div class="row">
                        <div class="text-center text-md-end mt-3 mt-md-4">
                            <a href="{{ route('restaurant-reviews.create', ['place_id' => $restaurant['place_id']]) }}" class="btn review_this_restaurant">Review this restaurant</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container mt-4">
            <div class="row g-2">
                <!-- メイン画像 -->
                <div class="col-md-8">
                    <img src="{{ $restaurant['photos'][0] ?? '/images/restaurants/default-restaurant.jpg' }}"
                        class="img-fluid rounded main-image" alt="Main Image">
                </div>

                <!-- サブ画像コンテナ -->
                <div class="col-md-4">
                    <div class="row g-2">
                        <!-- サブ画像1 -->
                        <div class="col-12">
                            <img src="{{ $restaurant['photos'][1] ?? '/images/restaurants/default-restaurant.jpg' }}"
                                class="img-fluid rounded sub-image" alt="Sub Image 1">
                        </div>
                        <!-- サブ画像2 -->
                        <div class="col-12">
                            <img src="{{ $restaurant['photos'][2] ?? '/images/restaurants/default-restaurant.jpg' }}"
                                class="img-fluid rounded sub-image" alt="Sub Image 2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- レストラン詳細情報 -->
        <div class="restaurant-details mt-4">
            <div class="row">
                <!-- 左側（ウェブサイト・連絡先） -->
                <div class="col-md-4">
                    <h3>Website</h3>
                    <p><a href="{{ $restaurant['website'] }}" target="_blank"
                            class="website-link">{{ $restaurant['website'] }}</a></p>

                    <h3>Contact</h3>
                    <p><i class="fa-solid fa-phone"></i> {{ $restaurant['phone'] ?? 'N/A' }}</p>

                    <h3>Price</h3>
                    <p>{!! isset($restaurant['price_level'])
                        ? str_repeat('<i class="fa-solid fa-yen-sign fs-3 text-muted me-1"></i>', $restaurant['price_level'])
                        : 'Price not available' !!}</p>
                </div>

                <!-- 中央（営業時間） -->
                <div class="col-md-4">
                    <h3>Hours</h3>
                    <ul class="list-unstyled">
                        @foreach ($restaurant['opening_hours'] as $hours)
                            <li><strong>{{ explode(':', $hours)[0] }}:</strong> {{ explode(':', $hours, 2)[1] }}</li>
                        @endforeach
                    </ul>
                </div>


                <!-- 右側（住所・マップ） -->
                <div class="col-md-4">
                    <h3>Location</h3>
                    <p><i class="fa-solid fa-map-marker-alt"></i> {{ $restaurant['address'] }}</p>
                    <div id="restaurant-map" style="height: 200px; width: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h2 class="mb-4 text-center review-count"> {{ count($reviews) }} Reviews</h2>
                @include('reviews.list', ['reviews' => $reviews])
            </div>
        </div>
    </div>

    <!-- Google Maps Script -->
    <script>
        function initMap() {
            var location = {
                lat: {{ $restaurant['lat'] }},
                lng: {{ $restaurant['lng'] }}
            };
            var map = new google.maps.Map(document.getElementById('restaurant-map'), {
                zoom: 15,
                center: location
            });
            new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>

    <!-- JavaScripts -->
    <script src="{{ asset('js/view_review.js') }}"></script>
@endsection
