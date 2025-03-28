<div class="reviews">
  @foreach ($reviews as $key => $review)
      <div class="border-top review-item-show px-5 py-4 {{ $key >= 5 ? 'd-none' : '' }} ">
          <div class="row">
              <!-- left side: review -->
              <div class="col-9">
                <div class="d-flex align-items-center mb-3">
                  <div class="me-3">
                    <a href="{{ route('mypage.show_others', ['userId' => $review->user_id]) }}">
                      @if ($review->user->avatar)
                          <img src="{{ Storage::url($review->user->avatar) }}" alt="Profile" class="rounded-circle avatar-circle">
                      @else
                          <div class="rounded-circle d-flex align-items-center justify-content-center bg-light avatar-circle-no-image">
                              <i class="fa-solid fa-user avatar-circle-icon"></i>
                          </div>
                      @endif
                    </a>
                  </div>
                  <div class="d-flex mt-1">
                    <a href="{{ route('mypage.show_others', ['userId' => $review->user_id]) }}" class="no-underline">
                      <h5 class="mb-0 me-4 text-dark">{{ $review->user->user_name }}</h5>
                    </a>
                    <span class="text-muted me-3">{{ $review->rating }}/5</span>
                    <div class="text-warning">
                      @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            <i class="fa-solid fa-circle rate-circle"></i>
                        @else
                            <i class="fa-regular fa-circle rate-circle"></i>
                        @endif
                      @endfor
                    </div>
                  </div>
                </div>
                <div>
                  <h6 class="card-title mt-2">{{ $review->title }}</h6>
                  <!-- Review Body with Read More -->
                  <div class="review-body mt-2">
                    <p class="short-text">{{ Str::limit($review->body, 200) }}</p>
                    <p class="full-text d-none">{{ $review->body }}</p>
                    @if (strlen($review->body) > 100)
                      <a href="#" class="read-more">Read more...</a>
                      <a href="#" class="read-less d-none">Read less</a>
                    @endif
                  </div>
                </div>

                <!-- photos -->
                <div class="photos d-flex mt-3">
                  @if ($review->photos)
                    @foreach ($review->photos as $photo)
                        <img src="{{ Storage::url($photo->photo) }}" class="rounded review-photo me-2">
                    @endforeach
                  @endif
                  
                </div>
              </div>
              
              <!-- right side: Itinerary -->
              <div class="col-3 d-flex align-items-start">
                @if (isset($review->itinerary))
                    <div class="card shadow-sm border-0 w-100">
                        <img src="{{ asset($review->itinerary->photo) }}" alt="Itinerary Photo" class="card-img-top review-itinerary">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1 review-itinerary-title">{{ $review->itinerary->title }}</h6>
                        </div>
                    </div>
                    
                @endif
              </div>
          </div>
      </div>
  @endforeach

  <div class="text-center mt-3">
    @if (count($reviews) > 5)
      <button id="loadMore" class="btn btn-secondary text-white mt-5">More</button>
    @endif
  </div>

</div>



