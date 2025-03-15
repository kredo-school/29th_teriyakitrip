@push('styles')
<link rel="stylesheet" href="{{ asset('css/search_spot.css') }}?v={{ time() }}">
@endpush

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

    {{-- 検索結果表示エリア --}}
    <div id="searchResults" class="search-results-container"></div>
</div>

<div class="col-md-3">
    @include('itineraries.search_detail')
</div>


@push('scripts')
<script src="{{ asset('js/search_spot.js') }}" defer></script>
@endpush
