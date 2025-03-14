@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/my_reviews_list.css') }}">
    <link rel="stylesheet" href="{{ asset('css/my_favorites.css') }}">

    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="fw-bold">Restaurant Reviews</h1>
            <a href="{{ route('restaurants.search') }}" class="btn create-review-btn">+ Create Review</a>
        </div>

        <!-- 📜 レビュー一覧 -->
        <div class="row">
            @if (count($reviews) > 0)
                @foreach ($reviews as $review)
                    <div class="col-md-12 position-relative review-container">
                        <div class="card review-card mb-3 d-flex flex-row align-items-center p-2">
                            <!-- 画像 -->
                            <div class="myreview-image-container">
                                <img src="{{ asset('storage/' . $review->photo) }}" class="favorite-image"
                                    alt="Restaurant Image">
                            </div>

                            <!-- カードの本文 -->
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <!-- レストラン名 & Rating を横並びに配置 -->
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0">{{ $review->restaurant_name }}</h5>
                                        <p class="text-warning mb-0 ms-3">
                                            @for ($i = 0; $i < $review->rating; $i++)
                                                <i class="fa-solid fa-circle text-warning"></i>
                                            @endfor
                                            @for ($i = $review->rating; $i < 5; $i++)
                                                <i class="fa-regular fa-circle text-warning"></i>
                                            @endfor
                                            ({{ $review->rating }})
                                        </p>
                                    </div>

                                    <!-- ⭐ レビュータイトル -->
                                    <h6 class="review-title fw-bold mt-2">{{ $review->title }}</h6>

                                    <!-- ⭐ レビュー本文 -->
                                    <p class="text-muted text-truncate mb-0" style="max-width: 400px;">{{ $review->body }}
                                    </p>
                                </div>

                                <!-- 🔽 "View This Review" ボタンを右下に配置 -->
                                <div class="mt-auto text-end w-100">
                                    <a href="#" class="btn view-review-btn btn-sm">View This Review</a>
                                </div>
                            </div>

                            <!-- 🗑️ Trashアイコンをカードの右端 & 縦中央に配置 -->
                            <button type="button" class="btn delete-review-btn trash-icon" data-bs-toggle="modal"
                                data-bs-target="#deleteReviewModal{{ $review->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ⭐ 各レビューごとの削除モーダル -->
                    <div class="modal fade" id="deleteReviewModal{{ $review->id }}" tabindex="-1"
                        aria-labelledby="deleteReviewModalLabel{{ $review->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteReviewModalLabel{{ $review->id }}">Confirm Delete
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this review?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                    <form method="POST" action="{{ route('review.delete') }}">
                                        @csrf
                                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                                        <button type="submit" class="btn delete-btn">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- 🚨 レビューがないときのメッセージ -->
                <div class="col-12 text-center mt-5">
                    <h5 class="text-muted">You haven't written any reviews yet.</h5>
                    <a href="{{ route('restaurants.search') }}" class="btn custom-create-review-btn mt-3">
                        Let's create your first review !
                    </a>                    

                </div>
            @endif
        </div>
    </div>

@endsection
