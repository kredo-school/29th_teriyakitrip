<div class="container mt-4"><br>

    @foreach ($restaurantReviews as $review)
    <div class="restaurant-review-card mb-4">
        <img src="{{ asset('images/' . $review->photo) }}" alt="{{ $review->restaurant_name }}" class="restaurant-thumbnail">
        
        <div class="restaurant-content d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold">{{ $review->restaurant_name ?? 'Restaurant' }}</h5>
                <div class="restaurant-rating mb-2">
                    @for ($i = 0; $i < 5; $i++)
                        <i class="{{ $i < $review->rating ? 'fas' : 'far' }} fa-circle"></i>
                    @endfor
                </div>
                <p class="restaurant-description">{{ $review->body }}</p>
            </div>

            <div class="text-end mt-2">
                <a href="#" class="btn btn-sm view-button">View this restaurant</a>
            </div>
        </div>
    </div>
    @endforeach

    <div class="text-center mt-4">
        <button class="btn btn-outline-dark px-4">MORE</button>
    </div>
</div><br>