@extends('layouts.app')

@section('title', 'Create Itinerary')

@section('content')

<style>
    .icon-sm {
        font-size: 2rem;
    }

    .swiper-container {
    width: 100%;
    overflow: hidden;
    /* padding: 10px 0; */
    background: #fff;
    position: relative;
}

.swiper-wrapper {
    display: flex;
}

.swiper-slide {
    flex-shrink: 0;
    width: auto;
    padding: 15px 20px;
    text-align: center;
    font-weight: bold;
    border-bottom: 3px solid transparent;
    cursor: pointer;
}

.active-tab {
    border-bottom: 3px solid #e91e63;
    color: black;
}

/* Swiper の矢印 */
.swiper-button-prev, .swiper-button-next {
    color: #e91e63;
}

/
    }

    .swiper-button-prev, .swiper-button-next {
        color: #e91e63;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10; /* 矢印を前面に */
        background: rgba(255, 255, 255, 0.8); /* 背景をつけて見やすく */
        border-radius: 50%;
        width: 25px;  /* 幅を小さく */
        height: 25px; /* 高さを小さく */
        font-size: 14px; /* アイコンの大きさも調整 */
        line-height: 25px;
        border: 1px solid #e91e63; /* 境界線はそのまま */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* 左矢印の位置調整 */
    .swiper-button-prev {
        left: 5px; /* 左端に配置 */
    }

    /* 右矢印の位置調整 */
    .swiper-button-next {
        right: 5px; /* 右端に配置 */
    }

    .swiper-wrapper {
        display: flex;
    }

    .swiper-slide {
        flex: 0 0 auto;
        width: 120px; /* 幅を広げる */
        text-align: center; /* テキストを中央揃え */
        padding: 10px; /* 余白をつける */
    }

</style>

<div class="container">
    <div class="row y-0">
        <div class="col-6 bg-warning">

          {{-- title, edit done btn --}}
          <div class="row align-items-center mt-2">
              <div class="col-auto">
                  <i class="fa-solid fa-arrow-left fs-2"></i>
              </div>
              <div class="col-8" style="display: inline-block; border-bottom: 1px solid black;">
                
                  <p class="h4 fw-bold">2025 Okinawa Trip</p>
                
                  
              </div>
              <div class="col-auto">
                  <i class="fa-solid fa-lock fs-2"></i>
              </div>
              <div class="col-auto float-end">
                <i class="fa-solid fa-pencil"></i> Done
              </div>
          </div>
          {{-- dates, destination, avatar --}}
          <div class="row align-items-center mt-2 g-0">
              <div class="col-3">
                  <div class="row">
                      <div class="col-12">
                            <p class="text-center float-start">
                                2025/-/- <strong>-</strong> 2025/-/- <br>
                                <span class="mt-0">4days</span>
                            </p>
                            &nbsp;<i class="fa-solid fa-calendar-days"></i>
                      </div>                        
                  </div>
                  
              </div>
              <div class="col-auto mx-auto ms-4">
                    <button type="" class="btn btn-light btn-md">Destination</button>
              </div>
              <div class="col-auto">
                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                    <i class="fa-solid fa-user-plus icon-sm"></i>
              </div>
              
          </div>

          {{-- overview, day --}}
          <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide active-tab ">Overview</div>
                    <div class="swiper-slide">Jan 17 <br> Day 1</div>
                    <div class="swiper-slide">Jan 18 <br> Day 2</div>
                    <div class="swiper-slide">Jan 19 <br> Day 3</div>
                    <div class="swiper-slide">Jan 20 <br> Day 4</div>
                </div>
        
                <!-- 左右のナビゲーションボタン -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                
          </div>
        
          {{-- <div class="row align-items-center">
                <div class="col-12 bg-light border border-1 border-dark" style="height: 50px;">
                    <div class="row">
                        <div class="col-auto mt-2 "> 
                            <i class="fa-solid fa-angle-left icon-sm"></i>
                        </div>
                    </div>
                </div>
          </div> --}}
        </div>
    </div>
</div>
@endsection