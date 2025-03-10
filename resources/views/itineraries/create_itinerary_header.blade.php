
<div class="col-6 w-50 wrapper">

    {{-- title, edit done btn --}}
    <div class="row align-items-center mt-2">


        <div class="d-flex align-items-center justify-content-start w-100">
            <div class="col-auto">
                <a href="#" class="text-dark">
                    <i class="fa-solid fa-arrow-left fs-2"></i>
                </a>
            </div>
            <div class="ms-3 flex-grow-1">
                <div class="form-item">
                    <label for="title" class="edit-title"></label>
                    <input type="text" name="title" id="title" placeholder="{{ $itinerary->title }}" required autofocus class="bg-transparent itinerary-header auto-width-input">
                </div>
            </div>
            <div class="col-auto">
                <i class="fa-solid fa-lock fs-2"></i>
            </div>
            <div class="col-auto ms-auto">
                <button type="submit" class="border-0 bg-transparent btn-sm">
                    <i class="fa-solid fa-pencil"></i> Done
                </button>
            </div>
        </div>
    </div>

    {{-- dates, destination, avatar --}}
    <div class="row align-items-center mt-2 g-0">
        <div class="col-auto">
            <div class="row">
                <div class="col-12">
                        <p class="text-center float-start">
                            {{ \Carbon\Carbon::parse($itinerary->start_date)->format('Y-m-d') }} <strong>-</strong> {{ \Carbon\Carbon::parse($itinerary->end_date)->format('Y-m-d') }} <br>
                            <span class="mt-0">4days</span>
                        </p>
                        &nbsp;<i class="fa-solid fa-calendar-days mt-3"></i>
                </div>                        
            </div>

        </div>
        <div class="col-auto mx-auto ms-4 mb-3">
                <button type="" class="btn btn-light btn-md">Destination</button>
        </div>
        <div class="col-auto">
            {{-- Auth icon --}}
            <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
            {{-- member + icon --}}
            <i class="fa-solid fa-user-plus"></i>
        </div>

    </div>

    {{-- prefecture-box --}}
    <div class="d-flex flex-wrap">
        @foreach ($itinerary->prefectures as $prefecture)
            <div class="prefecture-box text-center text-dark px-2 round">
                {{ $prefecture->name }}
            </div>
        @endforeach
    </div>
    {{-- @foreach ($itinerary->prefectures as $prefecture)
        <div class="prefecture-box text-center text-dark px-2 round">{{ $prefecture->name }}</div>
    @endforeach --}}

    {{-- overview, day --}}
    <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide active-tab overview-margin">Overview</div>
                <div class="swiper-slide">
                    <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                        Day 1
                    <i class="fa-solid fa-trash-can float-end mt-1"></i>
                </div>
                <div class="swiper-slide">
                    <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                        Day 2
                    <i class="fa-solid fa-trash-can float-end mt-1"></i>
                </div>
                <div class="swiper-slide">
                    <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                        Day 3
                    <i class="fa-solid fa-trash-can float-end mt-1"></i>
                </div>
                <div class="swiper-slide">
                    <i class="fa-solid fa-arrow-right-arrow-left float-start mt-1"></i> 
                        Day 4
                    <i class="fa-solid fa-trash-can float-end mt-1"></i>
                </div>
                
                <div class="swiper-slide"> 
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
            <!-- 左右のナビゲーションボタン -->
            
                <div class="swiper-button-prev ms-2"></div>
                <div class="swiper-button-next me-2"></div>
            
            
            

    </div>

    {{-- include body here--}}
    @include('itineraries.create_itinerary_body')
</div>
    

    