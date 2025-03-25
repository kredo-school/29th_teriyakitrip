@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/create_review.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit_myreview.css') }}">


<div class="container m-4 mx-5">
    <div class="row">
        <!-- Restaurant info (name and photo) -->
        <div class="col-md-5">
            <div class="restaurant-header mb-4 px-4">
                <h2>{{ $restaurant['name'] }}</h2>
                <div class="restaurant-image">
                    <img src="{{ $restaurant['photo'] }}" alt="{{ $restaurant['name'] }}" class="img-fluid">
                </div>
            </div>
        </div>

        <!-- Review edit form -->
        <div class="col-md-7">
            <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="review-detail px-2 py-4">
                    <div class="mb-4">
                        <label class="fw-bold mb-2">Rate this restaurant</label>
                        <div class="rating mb-2">
                          @for ($i = 1; $i <= 5; $i++)
                              <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="d-none" {{ $review->rating == $i ? 'checked' : '' }}>
                              <label for="star{{ $i }}" class="rating-label">
                                  <i class="fa-solid fa-circle {{ $review->rating >= $i ? 'selected' : '' }}" data-value="{{ $i }}"></i>
                              </label>
                          @endfor
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Title your review</label>
                        <input type="text" name="title" class="form-control" value="{{ $review->title }}" required>
                    </div>

                    <!-- Body -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Your review</label>
                        <textarea name="body" class="form-control" rows="5" required>{{ $review->body }}</textarea>
                    </div>

                    <!-- Existing and New Photos Container -->
                    @if ($photos->count() > 0)
                    <div class="review-images mt-3" id="existing-photos" style="display: flex; flex-wrap: wrap;">
                        @foreach ($photos as $photo)
                            <div class="position-relative d-inline-block image-container">
                                
                                <img src="{{ asset('storage/' . $photo->photo) }}" class="review-photo" alt="Review Image">

                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-photo" 
                                        data-photo-id="{{ $photo->id }}">
                                    ×
                                </button>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- モーダルを読み込む -->
                    @include('reviews.partials.modal_photo_delete') 

                    <!-- Add new photos -->
                    <div class="mb-4 mt-3">
                        <label class="form-label fw-bold">Add new photos</label>
                        <input type="file" name="photos[]" id="photo-input" class="form-control" multiple>
                        <small class="text-muted">Use 'Command' (Mac) or 'Ctrl' (Windows) to select multiple photos.</small>
                    </div>

                    <!-- Add additional photos (if needed) -->
                    <div class="mb-4 mt-3">
                        <label class="form-label fw-bold">Add more photos (Optional)</label>
                        <input type="file" name="additional_photos[]" id="additional-photo-input" class="form-control" multiple>
                        <small class="text-muted">You can upload more photos here.</small>
                    </div>


                    <!-- Submit button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-submit">Update Review</button>
                        <a href="{{ route('reviews.view_myreview', $review->id) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                    {{-- <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form> --}}
                    
                    
                </div>
            </form>
        </div>
    </div> 
</div>

<!-- JavaScripts -->
<script src="{{ asset('js/rating.js') }}"></script>


@endsection
