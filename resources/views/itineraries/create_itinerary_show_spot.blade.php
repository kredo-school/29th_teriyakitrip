@extends('layouts.app')

@section('title', 'Itinerary Spots')

@section('content')
<link rel="stylesheet" href="{{ asset('css/itinerary_show_spot_body.css') }}">

<div class="container-fluid itinerary-container">
    <div class="row">
        <!-- 左側 (リスト) -->
        @include('itineraries.create_itinerary_show_spot_header', ['daysList' => $daysList, 'regions' => $regions])
        
        <div id="day-container" class="col-md-6 p-3">
            @foreach ($daysList as $index => $day)
                <div class="day-body" id="day-body-{{ $index + 1 }}" data-day="{{ $index + 1 }}">
                    <div class="day-header col-2 bg-warning p-2 rounded">
                        <h4 class="day-title m-0 text-white fw-bold">Day {{ $index + 1 }}</h4>
                    </div>
                    <i class="fa-regular fa-clock"></i>
                    <span class="spot-time text-primary">{{ $spot->visit_time ?? 'Not Set' }}</span>
                    <div class="spot-list" id="spot-list-{{ $index + 1 }}">
                        @foreach ($spots[$index + 1] ?? [] as $spot)
                            <div class="itinerary-spot card p-3 mb-2 d-flex flex-row align-items-center">
                                <img id="spot-image-{{ $spot->place_id }}" src="" alt="Spot Image" class="spot-img me-3">
                                <div class="flex-grow-1">
                                    <h5 id="spot-name-{{ $spot->place_id }}" class="mb-1">Loading...</h5>
                                    <p id="spot-address-{{ $spot->place_id }}" class="text-muted mb-0">Loading...</p>
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    
                                    <button class="btn btn-sm btn-danger remove-spot mt-2" data-id="{{ $spot->id }}">❌</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="plus-icon text-center">
                        <a href="{{ route('itineraries.spot.search', ['id' => $itinerary->id, 'visit_day' => $index + 1]) }}"
                            class="border-0 bg-transparent plus-btn" data-day="{{ $index + 1 }}">
                            <i class="fa-regular fa-square-plus"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 右側 (マップ) -->
        <div class="col-md-6">
            <div id="map" style="height: 100vh;"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
<script src="{{ asset('js/gmaps_for_itinerary.js') }}"></script>
<script src="{{ asset('js/create_itinerary_show_spot_header.js') }}"></script>
<script src="{{ asset('js/create_itinerary_show_spot_body.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".remove-spot").forEach(button => {
            button.addEventListener("click", function () {
                let spotId = this.dataset.id;
                console.log("Removing spot:", spotId);
                this.closest(".itinerary-spot").remove();
            });
        });
    });
</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".itinerary-spot").forEach(spot => {
        let imgElement = spot.querySelector(".spot-img");
        let placeId = imgElement ? imgElement.id.split("-")[2] : null;

        if (!placeId || placeId.length < 10) {  // 例: place_idが短すぎる場合は無効
            console.warn("無効な place_id:", placeId);
            return;
        }

        fetch(`/api/get-place-info/${placeId}`)
            .then(response => {
                if (!response.ok) throw new Error("APIリクエスト失敗");
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    console.error("Google API エラー:", data.error);
                    return;
                }

                document.getElementById(`spot-name-${placeId}`).innerText = data.name || "No Name";
                document.getElementById(`spot-address-${placeId}`).innerText = data.address || "No Address";
                document.getElementById(`spot-image-${placeId}`).src = data.photo || "https://via.placeholder.com/100";
            })
            .catch(error => console.error("エラー:", error));
    });
});
</script>
@endpush
