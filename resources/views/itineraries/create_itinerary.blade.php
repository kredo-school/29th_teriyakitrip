@extends('layouts.app')

@section('title', 'Create Your Itinerary')

@section('content')
<div class="row">
    <div class="col-6">
        {{-- create itinerary form here--}}
        @include('itineraries.create_itinerary_header', ['daysList' => $daysList])

    </div>
</div>

{{-- <div class="row">
    <div class="col-6">     
        @include('itineraries.create_itinerary_body', ['daysList' => $daysList])
    </div> 
    <!-- create_itinerary.blade.php に配置 -->
<div id="add-spot-container" style="display: none;">
    @include('itineraries.create_add')
</div> --}}

</div>
<div class="col-6">
    <!-- 右側にGoogle Map -->
    <div id="map" class="google-map-wrapper"></div>
</div>
@endsection

{{-- @push('scripts')
<script src="{{ asset('js/create_itinerary_body.js')}}" defer></script>
@endpush --}}