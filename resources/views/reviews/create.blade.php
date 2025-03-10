@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/create_review.css') }}">

<div class="container m-4 mx-5">
    <div class="row">
        <!-- left side（restautant info & Itineraries） -->
        <div class="col-md-5">
            @include('reviews.partials.restaurant_header', ['restaurant' => $restaurant])  <!-- upper left：restaurant info -->
            {{-- @include('reviews.partials.restaurant_itineraries')  <!-- lower left：Itineraries --> --}}
        </div>

        <!-- right side（review form） -->
        <div class="col-md-7">
            @include('reviews.partials.review_form')
        </div>
    </div>
</div>

<!-- preview modal -->
@include('reviews.partials.modal_photo_preview')

<!-- JavaScripts -->
<script src="{{ asset('js/create_review.js') }}"></script>

@endsection
