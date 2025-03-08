@extends('layouts.app')

@section('title', 'Create Your Itinerary')

@section('content')

<link rel="stylesheet" href="{{ asset('css/itinerary_header_styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/itinerary_body.css') }}">
<link rel="stylesheet" href="{{ asset('css/itinerary_edit.css') }}">
<link rel="stylesheet" href="{{ asset('css/show_itinerary.css') }}">

<div class="container">
  <div class="row y-0">
          {{-- create itinerary form here--}}
          @include('itineraries.create_itinerary_header', ['itinerary' => $itinerary])

          <!-- 右側にGoogle Map -->
          <div class="col-6">
              <div id="map" class="google-map-wrapper"></div>
          </div>
  </div>
</div>

@endsection