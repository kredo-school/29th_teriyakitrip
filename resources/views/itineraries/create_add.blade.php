  {{-- Select tab: Go back to Previous page, Search or Favorite --}}
<link rel="stylesheet" href="{{ asset('css/itinerary_search.css') }}">

<div class="container">
    <ul class="nav px-auto text-center fw-bold">
        <li class="nav-item border py-0">
            <a class="nav-link text-black py-0 pt-2" href="#"><i class="fa-solid fa-arrow-left fa-sm"></i></a>
        </li>        
        <li class="nav-item border px-2 py-0">            
            <a id="search-button" class="nav-link text-black py-0" href="javascript:void(0);">
                <i class="fa-solid fa-magnifying-glass py-0 fa-xs"></i>
                <p class="m-0 py-0 small">Search</p>
            </a>
        </li>
    
        <li class="nav-item border px-2 py-0">
            <a id="favorite-button" class="nav-link text-black py-0" href="javascript:void(0);">
                <i class="fa-solid fa-star py-0 fa-xs text-warning"></i>
                <P class="m-0 py-0 small">Favorite</P>
            </a>
        </li> 
    </ul>

    <!-- 🔹 閉じるボタン -->
    <div class="d-flex justify-content-end mt-2">
        <button id="close-add-spot" class="btn btn-danger btn-sm">× 閉じる</button>
    </div>

    <!-- 🔹 タブコンテンツ -->
    <div id="search-content" style="display: block;">
        @include('itineraries.search_spot')
    </div>

    <div id="favorite-content" style="display: none;">
        @include('itineraries.favorite_spot')
    </div>
</div> 

<script>
    document.getElementById('search-button').addEventListener('click', function() {
        document.getElementById('search-content').style.display = 'block';
        document.getElementById('favorite-content').style.display = 'none';
    });

    document.getElementById('favorite-button').addEventListener('click', function() {
        document.getElementById('search-content').style.display = 'none';
        document.getElementById('favorite-content').style.display = 'block';
    });

    // ✅ 閉じるボタンの動作を追加
    document.getElementById('close-add-spot').addEventListener('click', function() {
        document.getElementById('add-spot-container').style.display = 'none';
    });
</script>