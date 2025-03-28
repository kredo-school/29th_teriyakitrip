@push('styles')
<link rel="stylesheet" href="{{ asset('css/search_spot.css') }}?v={{ time() }}">
@endpush
{{-- ここに `itineraryId` を保持する `div` を配置 　Javascriptと整合性を保つため--}}
<div id="itinerary-data" data-itinerary-id="{{ $itinerary->id }}"></div>

<div class="container mb-3">
    <div class="input-group my-3">
        <form id="searchForm" class="form-inline justify-content-center mt-4">
            <div class="input-group mb-3">
                <input id="searchBox" type="text" class="form-control rounded-right-0" placeholder="Search attractions" name="query" aria-label="Search">
                <div class="input-group-append">
                    <button id="searchButton" class="btn btn-outline-secondary rounded-left-0" type="button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>        
        </form>    
    </div>

    {{-- 検索結果表示エリア --}}
    <div id="searchResults" class="search-results-container">
        @if(isset($spots) && count($spots) > 0)
            @foreach ($spots as $spot)
            <form action="{{ route('itineraries.spots.save', ['id' => $itinerary->id, 'visit_day' => session('selectedDay', 1)]) }}" method="POST">
                @csrf
                <input type="hidden" name="place_id" value="{{ $spot->place_id }}">
                <input type="hidden" name="spot_order" value="{{ $loop->index + 1 }}">
                <input type="hidden" name="visit_day" value="{{ session('selectedDay', 1) }}"> {{-- デフォルト値を1に設定 --}}

                <div class="search-result-card">
                    <div class="search-result-info">
                        <p class="search-result-name">{{ $spot->place_id }}</p>
                        <p class="search-result-address">（スポット詳細は Google API から取得）</p>
                    </div>
                    <form action="submit" action="{{ route('itineraries.spots.save', ['id' => $itinerary->id, 'visit_day' => session('selectedDay', 1)]) }}" method="POST">
                        @csrf
                    <div class="search-result-btn-container">
                        <button type="submit" class="btn-white-orange">Add to Itinerary</button>
                    </form>
                    </div>
                </div>
            </form>
            @endforeach
        @else
            <p class="text-warning">⚠️ まだ追加されたスポットがありません。</p>
        @endif
    </div>
</div>

<div class="col-md-3">
    @include('itineraries.search_detail')
</div>

@push('scripts')
{{-- JavaScriptは保存処理に影響しないように調整 --}}
<script src="{{ asset('js/search_spot.js') }}" defer></script>
@endpush
