@extends('layouts.app')

@section('title', 'Edit Itinerary')
    
@section('content')

<link rel="stylesheet" href="{{ asset('css/itinerary_header_styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/itinerary_body.css') }}">
<link rel="stylesheet" href="{{ asset('css/itinerary_edit.css') }}">

<div class="container">
    <div class="row y-0">
        <div class="col-6 w-50 wrapper d-flex flex-column">

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
                      <input type="text" name="title" id="title" placeholder="2025 Okinawa Trip" required autofocus 
                          class="bg-transparent itinerary-header auto-width-input">
                  </div>
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
                                2025/-/- <strong>-</strong> 2025/-/- <br>
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
                  <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                  <i class="fa-solid fa-user-plus icon-sm"></i>
              </div>

          </div>
            
          {{-- overview, day --}}
          <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide active-tab overview-margin">
                    Overview
                </div>
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
            
        
            <div class="mt-4 wrapper">
                <div class="row">
                    <div class="d-flex align-items-center">
                        <div class="day-box text-center text-light p-2 px-3">Day 1</div>
                    </div>
                </div>           
            
                {{-- Day1 8:00am--}}
                <div class="d-flex mt-3">
                    <button type="submit" class="border-0 bg-transparent d-flex align-items-center p-0">
                        <i class="fa-regular fa-clock icon-time"></i>
                    </button>
                    <p class="edit-time mb-0 ms-1">8:00 AM</p>
                </div>
                <div class="card itinerary-card mt-3 align-items-center w-100">
                <div class="row g-0 w-100 justify-content-center align-items-center">
                    <!-- 左側の画像 -->
                    
                        <div class="col-auto">
                            <img src="{{ asset('images/okinawa-mihama-american-village-38427.jpg') }}" class="rounded img-thumbnail" alt="Place Image">
                        </div>
            
                    <!-- 右側のテキストとアイコン -->
                        <div class="col">
                        <div class="card-body">
                            <h5 class="fw-bold">American Village</h5>
                        </div>
                        </div>
            
                        <!-- アイコンエリア -->
                        <div class="col-auto d-flex flex-column">
                            <button class="btn btn-link p-0"><i class="fa-solid fa-arrows-up-down text-dark fs-5"></i></button>
                            <button class="btn btn-link p-0"><i class="fa-solid fa-trash-can text-danger fs-5"></i></button>
                        </div>

                    </div>
                
                </div>
            
            {{-- Day1 10:00am --}}
                <div class="d-flex mt-3">
                    <button type="submit" class="border-0 bg-transparent d-flex align-items-center p-0">
                        <i class="fa-regular fa-clock icon-time"></i>
                    </button>
                    <p class="edit-time mb-0 ms-1">10:00 AM</p>
                </div>
                <div class="card itinerary-card mt-2 align-items-center w-100">
                    <div class="row g-0 w-100 justify-content-center align-items-center">
                    <!-- 左側の画像 -->
                    
                        <div class="col-auto">
                            <img src="{{ asset('images/okinawa-mihama-american-village-38427.jpg') }}" class="rounded img-thumbnail" alt="Place Image">
                        </div>
            
                    <!-- 右側のテキストとアイコン -->
                        <div class="col">
                        <div class="card-body">
                            <h5 class="fw-bold">American Village</h5>
                        </div>
                        </div>
            
                        <!-- アイコンエリア -->
                        <div class="col-auto d-flex flex-column">
                            <button class="btn btn-link p-0"><i class="fa-solid fa-arrows-up-down text-dark fs-5"></i></button>
                            <button class="btn btn-link p-0"><i class="fa-solid fa-trash-can text-danger fs-5"></i></button>
                        </div>

                    </div>
                </div>

                {{-- Day2 0:00 pm --}}
                <div class="row">
                    <div class="d-flex align-items-center mt-4">
                        <div class="day-box text-center text-light p-2 px-3">Day 2</div>
                    </div>
                </div>
                <div class="d-flex mt-3">
                    <button type="submit" class="border-0 bg-transparent d-flex align-items-center p-0">
                        <i class="fa-regular fa-clock icon-time"></i>
                    </button>
                    <p class="edit-time mb-0 ms-1">0:00 PM</p>
                </div>
                <div class="card itinerary-card mt-2 align-items-center w-100">
                    <div class="row g-0 w-100 justify-content-center align-items-center">
                    <!-- 左側の画像 -->
                    
                        <div class="col-auto">
                            <img src="{{ asset('images/okinawa-mihama-american-village-38427.jpg') }}" class="rounded img-thumbnail" alt="Place Image">
                        </div>
            
                    <!-- 右側のテキストとアイコン -->
                        <div class="col">
                        <div class="card-body">
                            <h5 class="fw-bold">American Village</h5>
                        </div>
                        </div>
            
                        <!-- アイコンエリア -->
                        <div class="col-auto d-flex flex-column">
                            <button class="btn btn-link p-0"><i class="fa-solid fa-arrows-up-down text-dark fs-5"></i></button>
                            <button class="btn btn-link p-0"><i class="fa-solid fa-trash-can text-danger fs-5"></i></button>
                        </div>
                    </div>
                </div> 

                {{-- + icon --}}
                <div class="plus-icon text-center mt-3">
                    <button type="submit" class="border-0 bg-transparent">
                        <i class="fa-regular fa-square-plus"></i>
                    </button>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection