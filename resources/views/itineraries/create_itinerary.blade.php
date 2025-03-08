@extends('layouts.app')

@section('title', 'Create Your Itinerary')

@section('content')
<div class="row">
    <div class="col-6">
        {{-- create itinerary form here--}}
        @include('itineraries.create_itinerary_header', ['daysList' => $daysList])

    </div>
</div>

<div class="row">
    <div class="col-6">     
        @include('itineraries.create_itinerary_body', ['daysList' => $daysList])
    </div> 
</div>
<div class="col-6">
    {{-- map here--}}
</div>
@endsection