@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/create_review.css') }}">
<link rel="stylesheet" href="{{ asset('css/view_myreview.css') }}">

<div class="container m-4 mx-5">
    <div class="row">
        <!-- left side（restautant name+photo & Itineraries） -->
        <div class="col-md-5">
            
            <div class="restaurant-header mb-4 px-4">
                <h2>{{ $restaurant['name'] }}</h2>

                <div class="restaurant-image">
                    <img src="{{ $restaurant['photo'] }}" alt="{{ $restaurant['name'] }}" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="col-md-7">
          <a class="btn btn-submit float-end" href="{{ route('reviews.edit_myreview', $review->id) }}">
              Edit
          </a>
          <div class="review-detail px-2 py-4">
                <div class="mb-4">
                    <p class="fw-bold">Rate this restaurant</p>
                    <div class="rating mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-regular fa-circle review-circle"></i>
                        @endfor
                    </div>
                </div>
            

                <!-- ★ タイトル -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Title your review</label>
                    <div class="form-control">{{ $review->title }}</div>
                </div>

                <!-- ★ 本文 -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Your review</label>
                    <div class="form-control" style="height: auto; min-height: 100px; overflow-y: auto; max-height: 200px;">
                    {{ $review->body }}
                    </div>
                </div>
              
              
                <!-- ★ 追加された写真 -->
                @if ($photos->count() > 0)
                    <div class="review-images mt-3">
                        @foreach ($photos as $photo)
                            @php
                                $image = storage_path('public/reviews/' . $photo->$photo)
                            @endphp
                            <div class="position-relative d-inline-block">
                                @if(file_exists($image))
                                    <img src="{{ asset('storage/reviews/' . $photo->photo) }}" 
                                        class="img-fluid rounded review-photo" 
                                        alt="Review Image">
                                @else
                                    <p>Image not found<p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- モーダル（画像プレビュー用） -->
                <div class="modal fade" id="photoPreviewModal" tabindex="-1" aria-labelledby="photoPreviewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img id="previewImage" class="img-fluid rounded">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- preview modal -->
@include('reviews.partials.modal_photo_myreview')

<!-- JavaScripts -->
<script src="{{ asset('js/view_review.js') }}"></script>


@endsection


{{-- <div class="mt-4">
  <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Back to Reviews</a>
</div> --}}
