@if($userItineraries->isNotEmpty())
    <div class="restaurant-itineraries text-center">
        <h6 class="fw-bold">Here are your itineraries that include this restaurant</h6>
        
        <div class="d-flex align-items-center justify-content-center mt-3">
            <!-- 左矢印（前のItineraryに変更） -->
            <i class="fa-solid fa-angle-left prev-itinerary mx-3" style="cursor: pointer;"></i>

            <!-- Itinerary カード -->
            <div class="card itinerary-card w-50" id="itineraryCard">
              <img id="itineraryPhoto" src="{{ $userItineraries->first()->photo }}" alt="Itinerary Image" class="img-fluid">
              <p class="card-title mt-1 py-1" id="itineraryTitle">{{ $userItineraries->first()->title }}</p>
            </div>

            <!-- 右矢印（次のItineraryに変更） -->
            <i class="fa-solid fa-angle-right next-itinerary mx-3" style="cursor: pointer;"></i>
        </div>
    </div>

    <!-- Itinerary データを JavaScript に渡す -->
    <script>
        const itineraries = @json($userItineraries);
    </script>
@endif
