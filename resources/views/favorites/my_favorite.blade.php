@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/my_favorites.css') }}">

<div class="container mt-4">
    <h2 class="fw-bold">My Favorite Itineraries</h2>

    @if(empty($favorites))
        <p class="text-muted">You haven't added any itineraries to your favorites yet.</p>
    @else
        <div class="row">
            @foreach ($favorites as $itinerary)
            <div class="col-md-12"> <!-- 横長にするため、1行1件表示 -->
                <div class="card mb-3 d-flex flex-row align-items-center p-3">
                    <!-- 画像の親コンテナ -->
                    <div class="position-relative">
                        <!-- 画像 -->
                        <img src="{{ asset($itinerary['image']) }}" class="rounded me-3" alt="Itinerary Image" 
                            style="width: 180px; height: 120px; object-fit: cover;">

                        <!-- ⭐ お気に入りアイコン（画像の右上に配置） -->
                        <form method="POST" action="{{ route('itinerary.unfavorite', $itinerary['id']) }}" 
                            class="position-absolute top-0 end-0 m-1">
                            @csrf
                            <button type="submit" class="favorite-btn border-0 bg-transparent">
                                <i class="fa-solid fa-star text-warning" style="font-size: 24px;"></i>
                            </button>
                        </form>
                    </div>

                    <!-- カードの本文 -->
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $itinerary['title'] }}</h5>
                            <p class="text-muted">Shared by: {{ $itinerary['user'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection



