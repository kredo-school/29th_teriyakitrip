@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/my_reviews_list.css') }}">

    <div class="container mt-4">
        <!-- ヘッダー部分 -->
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="fw-bold">Restaurant Reviews</h1>
            <a href="#" class="btn create-review-btn">+ Create Review</a>
        </div>

        <!-- 📜 レビュー一覧 -->
        <div class="row">
            @foreach ($reviews as $review)
                <div class="col-md-12 position-relative"> <!-- 横長にするため、1行1件表示 -->
                    <div class="card review-card mb-3 d-flex flex-row align-items-center p-2">
                        <!-- 画像 -->
                        <img src="{{ asset('images/Sample7.jpg') }}" class="review-image" alt="Restaurant Image">

                        <!-- カードの本文 -->
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $review['restaurant'] }}</h5>
                                <p class="text-warning">
                                    {{ str_repeat('★', $review['rating']) }}{{ str_repeat('☆', 5 - $review['rating']) }}
                                </p>
                                <p class="card-text text-truncate" style="max-width: 400px;">{{ $review['review'] }}</p>
                            </div>

                            <!-- 右下にボタンを配置 -->
                            <div class="text-end mt-4"> <!-- mt-4 で下に余白を追加 -->
                                <a href="#" class="btn view-review-btn btn-sm">View This Review</a>
                            </div>
                        </div>
                    </div>

                    <!-- 削除アイコン (Trash) をカードの外、右端に配置 -->
                    <button type="button" class="btn delete-review-btn position-absolute top-50 translate-middle-y"
                        style="right: -40px;" data-bs-toggle="modal" data-bs-target="#deleteReviewModal" data-review-id="#">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 削除確認モーダル -->
    <div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReviewModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this review?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cancel-btn" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('review.delete') }}">
                        @csrf
                        <input type="hidden" name="review_id" id="reviewIdToDelete">
                        <button type="submit" class="btn delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
