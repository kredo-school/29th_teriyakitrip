{{-- <div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
</div> --}}

<header>
    <div class="logo">
        {{-- <img src="{{ asset('Teriyaki_logo.png') }}" alt="ロゴ" width="100" height="100"> --}}
        <img src="images/Teriyaki_logo.png" alt="ロゴ" width="80" height="80">
    </div>
    <!-- その他のヘッダー要素 -->
</header>

<header class="bg-white py-3 shadow-sm">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <!-- ロゴ -->
            <div>
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/teriyaki-trip-logo.png') }}" alt="Teriyaki Trip Logo" width="96" height="80">
                </a>
            </div>

            <!-- 検索バー -->
            <div class="d-flex align-items-center">
                <select class="form-select me-2">
                    <option>Select</option>
                    <option>Option 1</option>
                    <option>Option 2</option>
                </select>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search here...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>

            <!-- ナビゲーションボタンとプロフィール画像 -->
            <div class="d-flex align-items-center">
                <a href="#" class="btn btn-outline-warning me-2">Create Itinerary</a>
                <a href="#" class="btn btn-outline-warning me-2">Create Review</a>
                <img src="{{ asset('images/default-profile.png') }}" alt="Profile" class="rounded-circle" width="40" height="40">
            </div>
        </div>
    </div>
</header>
