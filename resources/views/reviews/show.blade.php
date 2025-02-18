@extends('layouts.app')

@section('content')

<div class="container my-5 px-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center review-count"> {{ count($restaurant->reviews) }} Reviews</h2>
            @include('reviews.list', ['reviews' => $restaurant->reviews])
        </div>
    </div>
</div>

@endsection
