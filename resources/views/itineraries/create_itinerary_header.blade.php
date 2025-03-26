<link rel="stylesheet" href="{{ asset('css/itinerary_header_styles.css') }}">
<!-- Laravelの変数をJSで取得するためのhidden要素 -->

<form id="itinerary-form" method="POST" action="{{ route('itineraries.save', ['id' => $itinerary->id]) }}">
@csrf
<div class="container">
    <div id="itinerary-data" data-itinerary-id="{{ $itinerary->id }}"></div>
    <input type="hidden" id="user-id" name="user_id" value="{{ auth()->id() }}">
    <div class="row y-0">
        <div class="col w-50 wrapper">
            {{-- タイトル・編集ボタン --}}
            <div class="row align-items-center mt-2">
                <div class="d-flex align-items-center justify-content-start w-100">
                    <div class="col-auto">
                        <a href="#" class="text-dark"> {{-- 行き先は未定　あとで決める　どこに戻すのか？  --}}
                            <i class="fa-solid fa-arrow-left fs-2"></i>
                        </a>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="form-item">
                            <label for="title" class="edit-title"></label>
                            <input type="text" name="title" id="title" 
                                class="bg-transparent itinerary-header auto-width-input" 
                                value="{{ $itinerary->title }}">
                        </div>
                    </div>
                    {{-- 公開/非公開トグル --}}
                    <div class="col-auto">
                        <i id="toggle-public" class="fa-solid fs-2 cursor-pointer 
                            {{ $itinerary->is_public ? 'fa-lock-open text-success' : 'fa-lock text-secondary' }}">
                        </i>
                    </div>   
                    <div class="col-auto ms-auto">
                        <button type="submit" class="border-0 bg-transparent btn-sm">
                            <i class="fa-solid fa-pencil"></i> Done
                        </button>
                    </div>             
                </div>
            </div>
            {{-- 日程・日数・目的地ボタン --}}
            <div class="row align-items-center mt-2 g-0">
                <div class="col-auto">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-center float-start">
                                <input type="date" name="start_date" id="start_date" value="{{ $itinerary->start_date }}" class="date-input">
                                <strong>-</strong> 
                                <input type="date" name="end_date" id="end_date" value="{{ $itinerary->end_date }}" class="date-input">
                                <br>
                                <span id="trip_days">{{ $days }} days</span>
                            </p>
                            &nbsp;<i class="fa-solid fa-calendar-days mt-3"></i>
                        </div>                        
                    </div>
                </div>                
                <div class="col-auto mx-auto ms-4 mb-3">
                    <button type="button" id="destination-btn" class="btn btn-light btn-md" data-bs-toggle="modal" data-bs-target="#itineraryModal">Destination</button>
                </div>
                <div class="col-auto">
                    {{-- Auth icon --}}
                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                    {{-- member + icon --}}
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>    

            {{-- Modal destination list --}}
            <div class="modal fade" id="itineraryModal" name="itineraryModal" tabindex="-1" aria-labelledby="itineraryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="flex-grow-1  modal-header d-flex justify-content-between align-items-center mb-4">
                            <!-- Page title with × button for cancel -->
                            <h5 class="modal-title  text-center fw-bold fs-4" id="itineraryModalLabel">Choose your Destination</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="×"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container border rounded-2">
            
                                <!-- Listing of prefectures by region group -->            
                                <div class="regions-container">
                                    @foreach($regions as $region)
                                        <div class="row mb-4">       
                                                <!-- Display Regions Name -->
                                            <div class="col-2 region-title px-3 py-2 text-white me-3 rounded"
                                                style="background-color: {{ $region->color }};">
                                                {{ $region->name }}
                                            </div>      <!-- Display Prefecture name by Region group -->
                                            <div class="col-9 mx-2 d-flex flex-wrap">
                                                @foreach($region->prefectures as $prefecture)
                                                    <div class="region-options"> 
                                                        <label class="form-check-label d-flex align-items-center pe-3">
                                                            <input type="checkbox" name="selected_prefectures[]" value="{{ $prefecture->id }}" data-color="{{ $prefecture->color }}" class="form-check-input me-1" {{ in_array($prefecture->id, old('prefectures', $selectedPrefectures) ?? []) ? 'checked' : '' }}>
                                                            <span class="flex-grow-1">{{ $prefecture->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
        
                                    <!-- Save button -->
                                <div class="text-center mt-3">
                                    <button type="button" id="save-destination"  class="btn btn-white-orange px-4 btn-white-orange:hover">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ★ 都道府県リスト（色付きラベル） --}}
            <div class="row ">
                <div class="col mt-0 mb-2 ms-2">
                    <div id="selected-destination-list" class="d-flex flex-nowrap overflow-auto">
                        @foreach($itinerary->prefectures as $prefecture)
                            <span class="badge rounded-pill px-3 py-2 text-white me-2 fs-6"
                                style="background-color: {{ $prefecture->color }};">
                                {{ $prefecture->name }}
                            </span>
                        @endforeach
                    </div>
                    <!-- フォーム送信用の hidden input prefecture -->
<input type="hidden" name="selected_prefectures" id="selected-prefectures">

                </div>
            </div>
            {{-- Overview・日付タブ --}}
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide active-tab overview-margin">Overview</div>
                    
                    @foreach($daysList as $day)
                    <div class="swiper-slide day-tab" data-day="{{ $loop->index + 1 }}">
                        <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                        {{ $day }}
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
        </div>
    </div>
    <div class="row">
        <div class="col-6">     
            @include('itineraries.create_itinerary_body', ['daysList' => $daysList])
        </div> 
</div>
</form>


@push('scripts')
<script src="{{ asset('js/create_itinerary_header.js')}}" defer></script>
@endpush
<input type="hidden" id="itinerary-id" name="itinerary_id" value="{{ $itinerary->id ?? '' }}">
