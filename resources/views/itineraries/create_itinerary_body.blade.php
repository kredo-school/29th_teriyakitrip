<link rel="stylesheet" href="{{ asset('css/itinerary_body.css') }}">
{{-- Bladeのループの最小値を1にする --}}

<<div class="mt-4 wrapper" id="day-container">
    @foreach($daysList as $day)
    @php
$dayIndex = max(1, $loop->index + 1);
@endphp
        <div class="row mt-2 day-body" id="day-body-{{ $loop->index + 1 }}" data-day="{{ $loop->index + 1 }}">
            <div class="col-2">
                <div class="day-box text-center text-light">Day {{ $loop->index + 1 }}</div>
            </div>
            <div class="plus-icon text-center">
                <button type="button" class="border-0 bg-transparent">
                    <i class="fa-regular fa-square-plus"></i>
                </button>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script src="{{ asset('js/create_itinerary_body.js')}}" defer></script>    
@endpush