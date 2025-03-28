<div class="container mt-4"><br>

    @foreach ($itineraries as $itinerary)
    <div class="itinerary-card mb-4">
        <img src="{{ asset('images/' . $itinerary->photo) }}" alt="{{ $itinerary->title }}" class="itinerary-thumbnail">

        <div class="itinerary-content d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold">{{ $itinerary->title }}</h5>
                <p class="itinerary-description">{{ $itinerary->description }}</p>
            </div>
            <div class="text-end mt-2">
                <a href="{{ route('itineraries.show', $itinerary->id) }}" class="btn btn-sm itinerary-btn">View this itinerary</a>
            </div>
        </div>
    </div>
    @endforeach

    <div class="text-center mt-4">
        <button class="btn btn-outline-dark px-4">MORE</button>
    </div>
</div><br>