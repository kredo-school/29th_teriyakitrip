{{-- This contents moved to views/mypage/index.blade.php 
I will keep this file just in case by naho--}}

{{-- Overview.blade.php : 中身だけを返す部分ビュー --}}

<div class="mt-4 text-center">
    <p style="color: #E97911; font-size: 3rem; font-weight: bold">Itinerary</p>
    <div class="container toppage mt-5">
        <div class="row mt-3">
            @foreach ($itineraries->take(3) as $itinerary)
                <div class="col-4">
                    <div class="card shadow-sm border-0 w-100 rounded-4">
                        <img src="{{ asset('images/' . $itinerary->photo) }}" alt="{{ $itinerary->title }}" class="element-style rounded-top-4" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;">
                                {{ $itinerary->title }}
                            </h6>
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpeg') }}" class="rounded-circle" style="width: 40px; height: 40px;">
                                <span class="ms-2 fw-bold">{{ $user->user_name }}</span>
                                <button class="btn btn-outline-warning btn-sm ms-auto">Follow</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('mypage.index', ['tab' => 'itineraries']) }}" class="btn btn-outline-secondary"
           style="color: rgb(104,102,102); border-color: rgb(104,102,102); font-size: 1em;">
            More
        </a>
    </div>
</div>

<!-- Restaurant Reviews Section -->
<div class="mt-5 text-center">
    <p style="color: #E97911; font-size: 3rem; font-weight: bold">Restaurant's Review</p>
    <div class="container toppage mt-5">
        <div class="row mt-3">
            @foreach ($topRestaurantReviews as $review)
                <div class="col-4">
                    <div class="card shadow-sm border-0 w-100 rounded-4">
                        {{-- <img src="{{ $review->photo_url ?? asset('images/sample-restaurant.jpg') }}" alt="Restaurant" class="element-style rounded-top-4" style="height: 200px; object-fit: cover;"> --}}
                        <img src="{{ asset('images/' . $review->photo) }}" alt="Restaurant" class="element-style rounded-top-4" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1 fw-bold" style="font-size: 14px; text-align: left;">
                                {{ $review->restaurant_name }}
                                {{-- 星評価例 --}}
                                <span class="ms-2 text-warning">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="{{ $i < $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </span>
                            </h6>
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('images/default-avatar.jpeg') }}" class="rounded-circle" style="width: 40px; height: 40px;">
                                <span class="ms-2">{{ $review->comment }}</span>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('mypage.index', ['tab' => 'restaurant_reviews']) }}" class="btn btn-link" style="color: #E97911;">View more review</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('mypage.index', ['tab' => 'restaurant_reviews']) }}" class="btn btn-outline-secondary"
           style="color: rgb(104,102,102); border-color: rgb(104,102,102); font-size: 1em;">
            More
        </a>
    </div><br><br>
</div>