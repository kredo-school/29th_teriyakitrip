@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/view_review.css') }}">
<div class="container my-5 px-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center review-count"> {{ count($restaurant->reviews) }} Reviews</h2>
            @include('reviews.list', ['reviews' => $restaurant->reviews])
        </div>
    </div>
</div>

<!-- JavaScripts -->
<script src="{{ asset('js/view_review.js') }}"></script>

@endsection
