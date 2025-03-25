<h2 class="text-center mb-4" style="color: #E97911; font-weight: bold;">Itineraries</h2>

@foreach ($itineraries as $itinerary)
    <div class="mb-4 d-flex justify-content-center">
        <div class="d-flex p-3 shadow-sm" style="border-radius: 15px; background-color: #fff; max-width: 1000px; width: 100%;">
            <!-- Image -->
            <div style="flex: 0 0 200px;">
                <img src="{{ asset('images/' . $itinerary->photo) }}"
                     alt="{{ $itinerary->title }}"
                     style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
            </div>

            <!-- Text -->
            <div class="ms-3 d-flex flex-column justify-content-between" style="flex: 1;">
                <div>
                    <h5 class="fw-bold mb-2" style="font-size: 1.1rem;">{{ $itinerary->title }}</h5>
                    <p class="text-muted" style="font-size: 0.9rem;">{{ $itinerary->description }}</p>
                </div>
                <div class="text-end">
                    <a href="#"
                       class="btn btn-sm"
                       style="background-color: #f2f2f2; color: #555; font-size: 0.75rem; padding: 4px 10px; border-radius: 5px;">
                        View this itinerary
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="text-center mt-4">
    <button class="btn btn-secondary" style="border-radius: 5px; padding: 0.5rem 1rem;">MORE</button>
</div><br><br>