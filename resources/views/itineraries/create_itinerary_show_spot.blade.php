@extends('layouts.app')

@section('content')
<div class="container">
    {{-- ✅ ヘッダー部を統合 --}}
    {{-- @include('itineraries.create_itinerary_show_spot_header', ['daysList' => $daysList, 'regions' => $regions]) --}}


    <h2>旅程のスポット一覧</h2>
    
    <div class="row">
        <div class="col-12">
            <div id="itinerary-spot-body" data-itinerary-id="{{ $itinerary->id }}">
                {{-- @dd($spots->toArray()); --}}
                @foreach($spots as $visitDay => $daySpots)
                <h3>Day {{ $visitDay }}</h3>
                @foreach($daySpots as $spot)
                    <div class="spot-item">
                        <p><strong>Spot:</strong> {{ $spot->place_id }}</p>
                        <p><strong>Order:</strong> {{ $spot->spot_order }}</p>
                        <p><strong>Visit Time:</strong> {{ $spot->visit_time ?? '未設定' }}</p>
                    </div>
                @endforeach
            @endforeach
            
            
            </div>
        </div>
    </div>

    {{-- <a href="{{ route('itinerary.show', ['id' => $itinerary->id]) }}" class="btn btn-primary">旅程に戻る</a> --}}
</div>

{{-- ✅ JavaScript を適用（絶対に `$days` を変更しない！） --}}
@push('scripts')
<script src="{{ asset('js/create_itinerary_show_spot_header.js')}}" defer></script>   
<script src="{{ asset('js/create_itinerary_body.js')}}" defer></script>   
<script>
    const itineraryId = "{{ $itinerary->id }}";
    let daysList = {!! json_encode($daysList) !!}; // ✅ 配列を `JSON` で埋め込む
    let regions = {!! json_encode($regions) !!}; // 🔥 `$regions` を JSON 形式で JS に渡す
</script> 
@endpush
@endsection
