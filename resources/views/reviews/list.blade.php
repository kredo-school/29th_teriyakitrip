<div class="reviews">
  @foreach ($reviews as $key => $review)
      <div class="border-top review-item-show px-5 py-4 {{ $key >= 5 ? 'd-none' : '' }} ">
          <div class="row">
              <!-- left side: review -->
              <div class="col-9">
                <div class="d-flex align-items-center mb-3">
                  <div class="me-3">
                    @if ($review->user->avatar)
                        <img src="{{ Storage::url($review->user->avatar) }}" alt="Profile" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-user" style="font-size: 24px; color: #666;"></i>
                        </div>
                    @endif
                  </div>
                  <div class="d-flex mt-1">
                    <h5 class="mb-0 me-4">{{ $review->user->user_name }}</h5>
                    <span class="text-muted me-3">{{ $review->rating }}/5</span>
                    <div class="text-warning">
                      @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            <i class="fa-solid fa-circle" style="color: #E97911; margin-right: 5px;"></i>
                        @else
                            <i class="fa-regular fa-circle" style="color: #E97911; margin-right: 5px;"></i>
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
                        <img src="{{ Storage::url($photo->photo) }}" class="rounded me-2" style="width: 100px; height: 100px; object-fit: cover;">
                    @endforeach
                  @endif
                  
                </div>
              </div>
              
              <!-- right side: Itinerary -->
              <div class="col-3 d-flex align-items-start">
                @if (isset($review->itinerary))
                    <div class="card shadow-sm border-0 w-100">
                        <img src="{{ asset($review->itinerary->photo) }}" alt="Itinerary Photo" class="card-img-top" style="object-fit: cover; height: 100px;">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1" style="font-size: 14px;">{{ $review->itinerary->title }}</h6>
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



