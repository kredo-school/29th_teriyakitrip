@extends('layouts.app')

@section('content')
<div class="container">
    <h2>スポット一覧</h2>
    @dd($spots);

    {{-- ✅ ShowSpot 専用のヘッダー --}}
    <div class="row">
        <div class="col-12">
            <h3>{{ $itinerary->title }}</h3>
            <p>期間: {{ $itinerary->start_date }} - {{ $itinerary->end_date }}</p>
        </div>
    </div>

    {{-- ✅ `daysList` を表示 --}}
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide active-tab overview-margin">Overview</div>

            @foreach($daysList as $day)
                <div class="swiper-slide day-tab" data-day="{{ $loop->index + 1 }}">
                    <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                    Day {{ $day }}
                    <i class="fa-solid fa-trash-can float-end mt-1 remove-day"></i>
                </div>
            @endforeach   
            <div class="swiper-slide" id="add-day"> 
                <i class="fa-solid fa-plus"></i>
            </div>
        </div>
    </div>

    <div class="swiper-button-prev ms-2"></div>
    <div class="swiper-button-next me-2"></div>     

    {{-- ✅ スポット一覧を表示 --}}
    <div id="itinerary-spot-body">
        @foreach($spots as $day => $spotList)
            <h4>Day {{ $day }}</h4>
            @foreach($spotList as $spot)
                <div class="spot-item">
                    <p><strong>Spot:</strong> {{ $spot->place_id }}</p>
                    <p><strong>Order:</strong> {{ $spot->spot_order }}</p>
                    <p><strong>Visit Time:</strong> {{ $spot->visit_time ?? '未設定' }}</p>
                </div>
            @endforeach
        @endforeach
    </div>

    <a href="{{ route('itinerary.show', ['id' => $itinerary->id]) }}" class="btn btn-primary">旅程に戻る</a>
</div>

@push('scripts')
<script src="{{ asset('js/create_itinerary_show_spot.js')}}" defer></script>   
@endpush
@endsection
