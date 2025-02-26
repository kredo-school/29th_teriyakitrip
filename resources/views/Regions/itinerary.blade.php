@extends('layouts.app')

@section('title', 'Itinerary')

{{-- ここでCSSを読み込む（他の人には影響なし） --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/regions-style.css') }}">
@endpush


@section('content')
<div class="container mt-4">
    <h2 class="fw-bold">Itinerary</h2>
    <div class="row">
        @foreach ($allItineraries as $trip)
        <div class="col-md-12">
            <div class="custom-card">
                <div class="card-image">
                    <img src="{{ asset('img/' . $trip['img']) }}" alt="{{ $trip['title'] }}">
                </div>
                <div class="card-content">
                    <h5>{{ $trip['title'] }}</h5>
                    <p>{{ $trip['description'] }}</p>
                    <button class="btn-view-itinerary">View this Itinerary</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
