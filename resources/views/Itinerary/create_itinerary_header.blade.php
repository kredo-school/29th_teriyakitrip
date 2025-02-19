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

    /* Swiper の矢印ボタン */
.swiper-button-prev, .swiper-button-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10; /* ボタンを前面に */
    background: rgba(255, 255, 255, 0.8); /* 背景をつけて見やすく */
    border-radius: 50%;
    width: 35px;
    height: 35px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e91e63;
    color: #e91e63;
    cursor: pointer;
}

    /* 左矢印の位置調整 */
    .swiper-button-prev {
        left: -10px; /* 左端に配置 */
    }

    /* 右矢印の位置調整 */
    .swiper-button-next {
        right: -10px; /* 右端に配置 */
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

    .overview-margin {
        margin-left: 30px;
        margin-right: 30px
    }


    .form-item {
    margin: 18px auto;
    border-bottom: 1px solid #000;
    overflow: hidden;
    
    }

    label {
    float: left;
    width: 20px;
    margin-right: 10px;
    text-align: center;
    }

    input {
    float: left;
    width: 89%;
    padding: 0 0 6px 0;
    /* background-color: #fff; */
    color: #000;
    font: 25px "Helvetica Neue";
    font-family: poppins;
    /* font-weight: 200px; */
    letter-spacing: 1.5px;
    outline: none;
    border: none;
    }
</style>

<div class="container">
    <div class="row y-0">
        <div class="col-6 bg-warning">

          {{-- title, edit done btn --}}
          <div class="row align-items-center mt-2">
              <div class="col-auto">
                <a href="#" class="text-dark">
                    <i class="fa-solid fa-arrow-left fs-2"></i>
                </a>
                  
              </div>
              <div class="col-8">
                
                  <div class="form-item">
                        <label for="title"></label>
                        <input type="text" name="title" id="title" placeholder="2025 Okinawa Trip" required autofocus class="bg-transparent">
                  </div>
                
                  
              </div>
              <div class="col-auto">
                  <i class="fa-solid fa-lock fs-2"></i>
              </div>
              <div class="col-auto float-end">
                    <button type="submit" class="border-0 bg-transparent btn-sm">
                        <i class="fa-solid fa-pencil"></i> Done
                    </button>
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
                    <div class="swiper-slide active-tab overview-margin">Overview</div>
                    <div class="swiper-slide">Day 1</div>
                    <div class="swiper-slide">Day 2</div>
                    <div class="swiper-slide">Day 3</div>
                    <div class="swiper-slide">Day 4</div>
                    <div class="swiper-slide"> 
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </div>
        
                <!-- 左右のナビゲーションボタン -->
                <div class="swiper-button-prev ms-2"></div>
                <div class="swiper-button-next me-2"></div>
                
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

          {{-- include body here--}}
          @include('itinerary.create_itinerary_body')
        </div>
    </div>
</div>
@endsection