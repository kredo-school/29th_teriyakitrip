<link rel="stylesheet" href="{{ asset('css/itinerary_body.css') }}">

{{-- Bladeのループの最小値を1にする --}}
<div class="mt-4 wrapper" id="day-container">
    @foreach($daysList as $day)
    @php
        $dayNumber = (int) filter_var($day, FILTER_SANITIZE_NUMBER_INT); // 🔥 ここで定義
        $generatedUrl = route('itineraries.spot.search', ['id' => $itinerary->id, 'visit_day' => $dayNumber]);
    @endphp

    <div class="row mt-2 day-body" id="day-body-{{ $dayNumber }}" data-day="{{ $dayNumber }}">
        dd($daysList);
        <div class="col-2">
            <div class="day-box text-center text-light">Day {{ $dayNumber }}</div>
        </div>
        <div class="plus-icon text-center">
            <a href="{{ route('itineraries.spot.search', ['id' => $itinerary->id, 'visit_day' => $dayNumber]) }}"
                class="border-0 bg-transparent plus-btn">
                <i class="fa-regular fa-square-plus"></i>
            </a>
        </div>
    </div>
@endforeach

</div>

<div id="day-container">
        <!-- JavaScript でスポット情報を追加 -->
    <div id="itinerary-data" data-itinerary-id="{{ $itinerary->id }}"></div>
</div>



<div class="col-auto" style="position: relative;">
    <div id="add-spot-container" style="display: none;">
        @include('itineraries.create_add')
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/create_itinerary_body.js')}}" defer></script>   
<script>
    const itineraryId = "{{ $itinerary->id }}";
</script> 
@endpush
